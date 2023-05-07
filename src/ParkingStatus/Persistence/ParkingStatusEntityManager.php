<?php
declare(strict_types=1);

namespace App\ParkingStatus\Persistence;

use App\Generated\TableMap\StatusTableMap;
use App\Generated\Transfer\StatusTransfer;
use App\Kernel\Persistence\AbstractEntityManager;

class ParkingStatusEntityManager extends AbstractEntityManager implements ParkingStatusEntityManagerInterface
{
    /**
     * @param \App\Generated\Transfer\StatusTransfer $statusTransfer
     *
     * @return void
     */
    public function saveStatusEntry(StatusTransfer $statusTransfer): void
    {
        $insertStatement = $this->getConnection()->prepare(
            "INSERT INTO ".StatusTableMap::TABLE_NAME.
            " (".
            StatusTableMap::COL_FK_PARKER.",".
            StatusTableMap::COL_FK_PARKING_SPOT.
            ") VALUES (?,?);"
        );

        $insertStatement->execute([
            $statusTransfer->getParkerId(),
            $statusTransfer->getParkingSpotId(),
        ]);
    }

    /**
     * @param \App\Generated\Transfer\StatusTransfer $statusTransfer
     *
     * @return void
     */
    public function updateStatusEntry(StatusTransfer $statusTransfer): void
    {
        $updateStatement = $this->getConnection()->prepare(
            "UPDATE ".StatusTableMap::TABLE_NAME." SET ".
            StatusTableMap::COL_FK_PARKER." = ?, ".
            StatusTableMap::COL_FK_PARKING_SPOT." = ? ".
            "WHERE ".StatusTableMap::COL_ID." = ?;"
        );

        $updateStatement->execute([
            $statusTransfer->getParkerId(),
            $statusTransfer->getParkingSpotId(),
            $statusTransfer->getId(),
        ]);
    }
}
