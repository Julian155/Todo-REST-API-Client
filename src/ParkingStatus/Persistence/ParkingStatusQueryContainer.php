<?php
declare(strict_types=1);

namespace App\ParkingStatus\Persistence;

use App\Generated\TableMap\ParkerTableMap;
use App\Generated\TableMap\ParkingSpotTableMap;
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
            " LEFT JOIN ".ParkingSpotTableMap::TABLE_NAME." ON ".
            StatusTableMap::COL_FK_PARKING_SPOT." = ".ParkingSpotTableMap::COL_ID.
            " WHERE ".ParkingSpotTableMap::COL_IS_RESERVED." = 0;"
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
            " LEFT JOIN ".ParkingSpotTableMap::TABLE_NAME." ON ".
            StatusTableMap::COL_FK_PARKING_SPOT." = ".ParkingSpotTableMap::COL_ID.
            " WHERE ".ParkingSpotTableMap::COL_IS_RESERVED." = 1;"
        );

        $statement->execute();

        return $statement;
    }

    /**
     * @param string $licencePlate
     *
     * @return \PDOStatement
     */
    public function queryStatusByParkerLicencePlate(string $licencePlate): PDOStatement
    {
        $query = $this->getConnection()->prepare(
            "SELECT ".
            StatusTableMap::COL_ID." AS id, ".
            StatusTableMap::COL_ARRIVED_AT." AS arrivedAt, ".
            StatusTableMap::COL_FK_PARKING_SPOT." AS parkingSpotId, ".
            StatusTableMap::COL_FK_PARKER." AS parkerId".
            " FROM ".StatusTableMap::TABLE_NAME.
            " LEFT JOIN ".ParkerTableMap::TABLE_NAME." ON ".
            ParkerTableMap::COL_ID." = ".StatusTableMap::COL_FK_PARKER.
            " WHERE ".ParkerTableMap::COL_LICENSE_PLATE." = ?;"
        );

        $query->execute([$licencePlate]);

        return $query;
    }
}
