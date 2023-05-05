<?php
declare(strict_types=1);

namespace App\Parker\Business\Writer;



use App\Database\ConnectionTrait;

class ParkerWriter
{
    use ConnectionTrait;

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
        $sqlStatement = $this->getConnection()->prepare("INSERT INTO Status (Einfahrtzeit,Ausfahrtzeit,Parkplatz_ID,Parker_ID) VALUES (?,?,?,?)");
        $sqlStatement->execute([date('d-m-y h:i:s'), null, null,$parkerID]);
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
        $sqlStatement = $this->getConnection()->prepare("INSERT INTO Status (Einfahrtzeit,Ausfahrtzeit,Parkplatz_ID,Parker_ID) VALUES (?,?,?,?)");
        $sqlStatement->execute([date('d-m-y h:i:s'), null, null,$parkerID]);
    }

    function createLicense($length = 8): string
    {
        return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', (int)ceil($length / strlen($x)))),1,$length);
    }
}
