<?php
declare(strict_types=1);

namespace App\Parker\Business\ParkerWriter;

use App\Database\ConnectionTrait;
use App\Generated\Transfer\ParkerTransfer;
use App\Generated\Transfer\StatusTransfer;
use App\Generated\Transfer\TicketTransfer;
use App\Parker\Persistence\ParkerEntityManagerInterface;
use App\ParkingStatus\Business\ParkingStatusFacadeInterface;
use DateTime;

class ParkerWriter implements ParkerWriterInterface
{
    use ConnectionTrait;

    /**
     * @var \App\Parker\Persistence\ParkerEntityManagerInterface
     */
    private ParkerEntityManagerInterface $parkerEntityManager;

    /**
     * @var \App\ParkingStatus\Business\ParkingStatusFacadeInterface
     */
    private ParkingStatusFacadeInterface $parkingStatusFacade;

    /**
     * @param \App\Parker\Persistence\ParkerEntityManagerInterface $parkerEntityManager
     * @param \App\ParkingStatus\Business\ParkingStatusFacadeInterface $parkingStatusFacade
     */
    public function __construct(
        ParkerEntityManagerInterface $parkerEntityManager,
        ParkingStatusFacadeInterface $parkingStatusFacade
    ) {
        $this->parkerEntityManager = $parkerEntityManager;
        $this->parkingStatusFacade = $parkingStatusFacade;
    }

    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return \App\Generated\Transfer\TicketTransfer
     */
    public function writeParkerAndStatusEntry(ParkerTransfer $parkerTransfer): TicketTransfer
    {
        $arrivedAt = (new DateTime())->format('Y-m-d H:m:s');

        $parkerTransfer =  $this->parkerEntityManager->saveParkerEntry($parkerTransfer);

        $statusTransfer = (new StatusTransfer())
            ->setParkerId($parkerTransfer->getId())
            ->setArrivedAt($arrivedAt);

        $this->parkingStatusFacade->saveParkingStatus($statusTransfer);

        return (new TicketTransfer())
            ->setLicencePlate($parkerTransfer->getLicencePlate())
            ->setArrivedAt($arrivedAt)
            ->setLongTermParkerId($parkerTransfer->getLongTermParkerId());
    }
    
    /**
     * @return void
     */
    public function writeShortTermParkerCheckInEntry(): void
    {

        $parkerID = $this->writeShortTermEntryInParker($this->createLicense(8));
        $this->writeShortTermEntryInStatus($parkerID);
    }

    public function writeLongTermParkerCheckInEntry(): void
    {

        $parkerID = $this->writeLongTermEntryInParker('1');
        $this->writeLongTermEntryInStatus($parkerID);
    }

    public function writeShortTermParkerCheckOutEntry(): void
    {
        $parkerInfo = $this->getCheckOutParker();
        $this->writeShortTermEntryInLogs($parkerInfo);

    }
    public function writeLongTermParkerCheckOutEntry(): void
    {
        $parkerInfo = $this->getCheckOutParker();
        $this->writeLongTermEntryInLogs($parkerInfo);
    }


    public function writeShortTermEntryInLogs(array $parkerInfo): void
    {
        if ($parkerInfo[0] == 'shortTermParker') {
            $sqlStatementParker = $this->getConnection()->prepare("SELECT * FROM Parker WHERE Kennzeichen = ?");
            $sqlStatementParker->execute([$parkerInfo[1]]);
            $parkerData = $sqlStatementParker->fetch();

            $sqlStatementParker = $this->getConnection()->prepare("SELECT * FROM Status WHERE Parker_ID = ?");
            $sqlStatementParker->execute([(int)$parkerData['ID']]);
            $statusData = $sqlStatementParker->fetch();

            $sqlStatement = $this->getConnection()->prepare("INSERT INTO Logs (Kennzeichen,Dauerparker_ID,Einfahrtzeit,Ausfahrtzeit,Bezahlt) VALUES (?,?,?,?,?)");
            $sqlStatement->execute([$parkerData['Kennzeichen'],null, $statusData['Einfahrtzeit'],date('d-m-y h:i:s'),1]);
            //$logEntryData = $sqlStatement->fetch();
            //dd($logEntryData);
            $this->deleteStatusEntry((int)$statusData['ID']);
            $this->deleteParkerEntry((int)$statusData['Parker_ID']);
        }
    }
    public function writeLongTermEntryInLogs(array $parkerInfo): void
    {
        if ($parkerInfo[0] == 'longTermParker') {
            $sqlStatementParker = $this->getConnection()->prepare("SELECT * FROM Parker WHERE Dauerparker_ID = ?");
            $sqlStatementParker->execute([$parkerInfo[1]]);
            $parkerData = $sqlStatementParker->fetch();

            $sqlStatementParker = $this->getConnection()->prepare("SELECT * FROM Status WHERE Parker_ID = ?");
            $sqlStatementParker->execute([(int)$parkerData['ID']]);
            $statusData = $sqlStatementParker->fetch();

            $sqlStatement = $this->getConnection()->prepare("INSERT INTO Logs (Kennzeichen,Dauerparker_ID,Einfahrtzeit,Ausfahrtzeit,Bezahlt) VALUES (?,?,?,?,?)");
            $sqlStatement->execute([null,(int)$parkerData['Dauerparker_ID'], $statusData['Einfahrtzeit'],date('d-m-y h:i:s'),0]);
            //$logEntryData = $sqlStatement->fetch();
            //print_r($logEntryData);
            //dd($logEntryData);
            $this->deleteStatusEntry((int)$statusData['ID']);
            $this->deleteParkerEntry((int)$statusData['Parker_ID']);
        }
    }

    public function getCheckOutParker(): array
    {
        // Through app input should be determined if its (longTermParker or shortTermParker)
        // ...
        // input -> pos1: type of parker / pos2: long term parker id
        return ['longTermParker',1];
    }

    public function deleteStatusEntry(int $ID): void
    {
        $sqlStatementParker = $this->getConnection()->prepare("DELETE FROM Status WHERE ID = ?");
        $sqlStatementParker->execute([$ID]);
    }
    public function deleteParkerEntry(int $ID): void
    {
        $sqlStatementParker = $this->getConnection()->prepare("DELETE FROM Parker WHERE ID = ?");
        $sqlStatementParker->execute([$ID]);
    }

    public function writeShortTermEntryInParker(string $licensePlate): int
    {
        $sqlStatement = $this->getConnection()->prepare("INSERT INTO Parker (Kennzeichen,Dauerparker_ID) VALUES (?,?)");
        $sqlStatement->execute([$licensePlate, null]);

        $sqlStatementParker = $this->getConnection()->prepare("SELECT ID FROM Parker WHERE Kennzeichen = ?");
        $sqlStatementParker->execute([$licensePlate]);
        $data = $sqlStatementParker->fetch();
        return (int) $data['ID'];
    }
    public function writeShortTermEntryInStatus(int $parkerID): void
    {
        $this->getNumbersOfUsedParkingLots($numberOfUsedLongTermParkingLots, $numberOfUsedShortTermParkingLots);

        if ((int)$numberOfUsedShortTermParkingLots < 140) {
            $shortTermParkingLotID = $this->chooseShortTermParkingLot();
            print_r($shortTermParkingLotID);
            $sqlStatement = $this->getConnection()->prepare("INSERT INTO Status (Einfahrtzeit,Ausfahrtzeit,Parkplatz_ID,Parker_ID) VALUES (?,?,?,?)");
            $sqlStatement->execute([date('d-m-y h:i:s'), null, $shortTermParkingLotID,$parkerID]);
        }
    }

    public function writeLongTermEntryInParker(string $longTermParkerID): int
    {
        $sqlStatement = $this->getConnection()->prepare("INSERT INTO Parker (Kennzeichen,Dauerparker_ID) VALUES (?,?)");
        $sqlStatement->execute([null, $longTermParkerID]);

        $sqlStatementParker = $this->getConnection()->prepare("SELECT ID FROM Parker WHERE Dauerparker_ID = ?");
        $sqlStatementParker->execute([$longTermParkerID]);
        $data = $sqlStatementParker->fetch();
        return (int) $data['ID'];
    }
    public function writeLongTermEntryInStatus(int $parkerID): void
    {
        $this->getNumbersOfUsedParkingLots($numberOfUsedLongTermParkingLots, $numberOfUsedShortTermParkingLots);
        // Maybe from 140 to 136

        //print_r((int)$numberOfUsedLongTermParkingLots);
        if (((int)$numberOfUsedLongTermParkingLots == 40) & (int)$numberOfUsedShortTermParkingLots == 140) {
            error_log('All long term and short term parking lots are used');
        }

        if (((int)$numberOfUsedLongTermParkingLots == 40) & ((int)$numberOfUsedShortTermParkingLots < 140)) {
            //print_r('1');
            $shortTermParkingLotID = $this->chooseShortTermParkingLot();
            $sqlStatement = $this->getConnection()->prepare("INSERT INTO Status (Einfahrtzeit,Ausfahrtzeit,Parkplatz_ID,Parker_ID) VALUES (?,?,?,?)");
            $sqlStatement->execute([date('d-m-y h:i:s'), null, $shortTermParkingLotID,$parkerID]);
        }
        if (((int)$numberOfUsedLongTermParkingLots < 40) & ((int)$numberOfUsedShortTermParkingLots == 140)) {
            //print_r('2');
            $longTermParkingLotID = $this->chooseLongTermParkingLot();
            $sqlStatement = $this->getConnection()->prepare("INSERT INTO Status (Einfahrtzeit,Ausfahrtzeit,Parkplatz_ID,Parker_ID) VALUES (?,?,?,?)");
            $sqlStatement->execute([date('d-m-y h:i:s'), null, $longTermParkingLotID,$parkerID]);
        }

        if (((int)$numberOfUsedLongTermParkingLots < 40) & ((int)$numberOfUsedShortTermParkingLots < 140)) {
            //print_r('3');
            $shortTermParkingLotID = $this->chooseShortTermParkingLot();
            $sqlStatement = $this->getConnection()->prepare("INSERT INTO Status (Einfahrtzeit,Ausfahrtzeit,Parkplatz_ID,Parker_ID) VALUES (?,?,?,?)");
            $sqlStatement->execute([date('d-m-y h:i:s'), null, $shortTermParkingLotID,$parkerID]);

            $longTermParkingLotID = $this->chooseLongTermParkingLot();
            $sqlStatement = $this->getConnection()->prepare("INSERT INTO Status (Einfahrtzeit,Ausfahrtzeit,Parkplatz_ID,Parker_ID) VALUES (?,?,?,?)");
            $sqlStatement->execute([date('d-m-y h:i:s'), null, $longTermParkingLotID,$parkerID]);
        }
    }

    /**
     * @param int $length
     *
     * @return string
     */
    function createLicense(int $length = 8): string
    {
        return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', (int)ceil($length / strlen($x)))),1,$length);
    }

    public function chooseShortTermParkingLot(): int
    {
        //Maybe -4
        $parkingLotID = rand(41,180);
        $sqlStatement = $this->getConnection()->prepare("SELECT COUNT(*) FROM Status WHERE ID = ?");
        $sqlStatement->execute([$parkingLotID]);
        //$parkingLotUsed = $sqlStatement->fetch();

        while (true) {
            // Maybe -4
            $parkingLotID = rand(41,180);
            $sqlStatement = $this->getConnection()->prepare("SELECT COUNT(*) FROM Status WHERE ID = ?");
            $sqlStatement->execute([$parkingLotID]);
            //$parkingLotUsed = $sqlStatement->fetch();
            if ($parkingLotID > 0) {
                break;

            }
        }
        return $parkingLotID;
    }

    public function chooseLongTermParkingLot(): int
    {
        $parkingLotID = rand(1,40);
        $sqlStatement = $this->getConnection()->prepare("SELECT COUNT(*) FROM Status WHERE ID = ?");
        $sqlStatement->execute([$parkingLotID]);
        //$parkingLotUsed = $sqlStatement->fetch();

        //print_r($parkingLotID);
        while (true) {
            $parkingLotID = rand(1,40);
            $sqlStatement = $this->getConnection()->prepare("SELECT COUNT(*) FROM Status WHERE ID = ?");
            $sqlStatement->execute([$parkingLotID]);
            //$parkingLotUsed = $sqlStatement->fetch();
            if ($parkingLotID > 0) {
                break;
            }
        }
        return $parkingLotID;
    }

    public function getNumbersOfUsedParkingLots(&$numberOfUsedLongTermParkingLots, &$numberOfUsedShortTermParkingLots)
    {
        $sqlStatement = $this->getConnection()->prepare("SELECT COUNT(*) FROM Status AS St JOIN Parkplatz AS Pa ON St.ID = Pa.ID WHERE Pa.Reserviert = 1");
        $sqlStatement->execute();
        $numberOfUsedLongTermParkingLots = $sqlStatement->fetchAll();

        $sqlStatement = $this->getConnection()->prepare("SELECT COUNT(*) FROM Status AS St JOIN Parkplatz AS Pa ON St.ID = Pa.ID WHERE Pa.Reserviert = 0");
        $sqlStatement->execute();
        $numberOfUsedShortTermParkingLots = $sqlStatement->fetchAll();

        //if ($numberOfUsedShortTermParkingLots == null) {
       //     $numberOfUsedShortTermParkingLots = 0;
        //}

        //if ($numberOfUsedLongTermParkingLots == null) {
       //     $numberOfUsedLongTermParkingLots = 0;
      //  }
    }
}
