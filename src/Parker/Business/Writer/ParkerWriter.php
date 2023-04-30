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
    public function writeParkerInstance(): void
    {
        $statement = $this->getConnection()->prepare("SELECT * FROM Parker;");
        $statement->execute();
        $data = $statement->fetchAll();
        dd($data);
    }
}
