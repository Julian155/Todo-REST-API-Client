<?php
declare(strict_types=1);

namespace App\ParkingStatus\Persistence;

use PDOStatement;

interface ParkingStatusQueryContainerInterface
{
    /**
     * @return \PDOStatement
     */
    public function queryFreeNormalParkingSpaces(): PDOStatement;

    /**
     * @return \PDOStatement
     */
    public function queryReservedParkingSpaces(): PDOStatement;

    /**
     * @param string $licencePlate
     *
     * @return \PDOStatement
     */
    public function queryStatusByParkerLicencePlate(string $licencePlate): PDOStatement;
}
