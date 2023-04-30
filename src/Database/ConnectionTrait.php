<?php
declare(strict_types=1);

namespace App\Database;

trait ConnectionTrait
{
    /**
     * @return \App\Database\MyPdo
     */
    public function getConnection(): MyPdo
    {
        return MyPdo::getConnection();
    }
}
