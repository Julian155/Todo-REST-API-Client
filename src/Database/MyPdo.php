<?php
declare(strict_types=1);

namespace App\Database;

use App\Kernel\Config;
use App\Shared\Database\DatabaseConstants;
use PDO;

class MyPdo extends PDO
{
    /**
     * @var \App\Database\MyPdo|null
     */
    protected static ?MyPdo $instance = null;
 
    /**
     * @param string $dsn
     * @param string $user
     * @param string $password
     */
    private function __construct(string $dsn, string $user, string $password)
    {
        parent::__construct($dsn, $user, $password, []);
    }

    /**
     * @return \App\Database\MyPdo
     */
    public static function getConnection(): MyPdo
    {
        if (!static::$instance) {
            static::$instance = new static(
                Config::get(DatabaseConstants::DATABASE_DSN),
                Config::get(DatabaseConstants::DATABASE_USER),
                Config::get(DatabaseConstants::DATABASE_PASSWORD),
            );
        }

        return static::$instance;
    }
}
