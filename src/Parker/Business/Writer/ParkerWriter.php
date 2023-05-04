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
        if ($parkerInfo[1] == 'shortTermParker') {
            $sqlStatementParker = $this->getConnection()->prepare("SELECT * FROM ID WHERE Kennzeichen = ?");
            $sqlStatementParker->execute([$parkerInfo[2]]);
            $data = $sqlStatementParker->fetch();

            $sqlStatementParker = $this->getConnection()->prepare("SELECT * FROM Status WHERE Parker_ID = ?");
            $sqlStatementParker->execute([(int)$data['ID']]);
            $data = $sqlStatementParker->fetch();

            $sqlStatement = $this->getConnection()->prepare("INSERT INTO Logs (Kennzeichen,Dauerparker_ID,Einfahrtzeit,Ausfahrtzeit,Bezahlt) VALUES (?,?,?,?,?)");
            $sqlStatement->execute([$data['Kennzeichen'], null,$data['Einfahrtzeit'],date('d-m-y h:i:s'),1]);
            $this->deleteStatusEntry((int)$data['ID']);
        }
    }
    public function writeLongTermEntryInLogs(array $parkerInfo): void
    {
        if ($parkerInfo[1] == 'longTermParker') {
            $sqlStatementParker = $this->getConnection()->prepare("SELECT * FROM ID WHERE Dauerparker_ID = ?");
            $sqlStatementParker->execute([$parkerInfo[2]]);
            $data = $sqlStatementParker->fetch();

            $sqlStatementParker = $this->getConnection()->prepare("SELECT * FROM Status WHERE Parker_ID = ?");
            $sqlStatementParker->execute([(int)$data['ID']]);
            $data = $sqlStatementParker->fetch();

            $sqlStatement = $this->getConnection()->prepare("INSERT INTO Logs (Kennzeichen,Dauerparker_ID,Einfahrtzeit,Ausfahrtzeit,Bezahlt) VALUES (?,?,?,?,?)");
            $sqlStatement->execute([null,$data['Dauerparker_ID'],$data['Einfahrtzeit'],date('d-m-y h:i:s'),1]);
            $this->deleteStatusEntry((int)$data['ID']);
            dd($data);
        }
    }

    public function getCheckOutParker(): array
    {
        // Through app input should be determined if its (longTermParker or shortTermParker)
        // ...
        return ['longTermParker',1];
    }

    public function deleteStatusEntry(int $ID): void
    {
        $sqlStatementParker = $this->getConnection()->prepare("DELETE FROM Status WHERE ID = ?");
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
