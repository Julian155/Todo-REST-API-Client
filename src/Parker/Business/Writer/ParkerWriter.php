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
    public function writeShortTermParkerEntry(): void
    {

        $parkerID = $this->writeShortTermEntryInParker('XXXXYYYY');
        $this->writeShortTermEntryInStatus($parkerID);
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




    public function writeLongTermParkerEntry(): void
    {

        $parkerID = $this->writeLongTermEntryInParker('1');
        $this->writeLongTermEntryInStatus($parkerID);
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
}
