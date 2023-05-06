<?php
declare(strict_types=1);

namespace App\ParkingStatus\Persistence;

use App\Generated\TableMap\ParkplatzTableMap;
use App\Generated\TableMap\StatusTableMap;
use App\Kernel\Persistence\AbstractQueryContainer;
use PDOStatement;

class ParkingStatusQueryContainer extends AbstractQueryContainer implements ParkingStatusQueryContainerInterface
{
    /**
     * @return \PDOStatement
     */
    public function queryFreeNormalParkingSpaces(): PDOStatement
    {
        $statement = $this->getConnection()->query(
            "SELECT COUNT(*) FROM ".StatusTableMap::TABLE_NAME.
            " LEFT JOIN ".ParkplatzTableMap::TABLE_NAME." ON ".
            StatusTableMap::COL_PARKPLATZ_ID." = ".ParkplatzTableMap::COL_ID.
            " WHERE ".ParkplatzTableMap::COL_RESERVIERT." = 0;"
        );

        $statement->execute();

        return $statement;
    }

    /**
     * @return \PDOStatement
     */
    public function queryReservedParkingSpaces(): PDOStatement
    {
        $statement = $this->getConnection()->query(
            "SELECT COUNT(*) FROM ".StatusTableMap::TABLE_NAME.
            " LEFT JOIN ".ParkplatzTableMap::TABLE_NAME." ON ".
            StatusTableMap::COL_PARKPLATZ_ID." = ".ParkplatzTableMap::COL_ID.
            " WHERE ".ParkplatzTableMap::COL_RESERVIERT." = 1;"
        );

        $statement->execute();

        return $statement;
    }
}
