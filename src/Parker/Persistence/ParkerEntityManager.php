<?php
declare(strict_types=1);

namespace App\Parker\Persistence;

use App\Generated\TableMap\ParkerTableMap;
use App\Generated\TableMap\StatusTableMap;
use App\Generated\Transfer\ParkerTransfer;
use App\Generated\Transfer\StatusTransfer;
use App\Kernel\Persistence\AbstractEntityManager;

class ParkerEntityManager extends AbstractEntityManager implements ParkerEntityManagerInterface
{
    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return \App\Generated\Transfer\ParkerTransfer
     */
    public function saveParkerEntry(ParkerTransfer $parkerTransfer): ParkerTransfer
    {
        $insertStatement = $this->getConnection()->prepare(
            "INSERT INTO ".ParkerTableMap::TABLE_NAME.
            " (".
                ParkerTableMap::COL_KENNZEICHEN.",".
                ParkerTableMap::COL_DAUERPARKER_ID.
            ") VALUES (?,?);"
        );

        $insertStatement->execute([
            $parkerTransfer->getKennzeichen(),
            $parkerTransfer->getDauerparkerId(),
        ]);

        $parkerTransfer->setId(
            (int) $this->getConnection()->lastInsertId()
        );

        return $parkerTransfer;
    }

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
            StatusTableMap::COL_EINFAHRTZEIT.",".
            StatusTableMap::COL_AUSFAHRTZEIT.",".
            StatusTableMap::COL_PARKPLATZ_ID.",".
            StatusTableMap::COL_PARKER_ID.
            ") VALUES (?,?,?,?);"
        );

        $insertStatement->execute([
            $statusTransfer->getEinfahrtzeit(),
            $statusTransfer->getAusfahrtzeit(),
            $statusTransfer->getParkplatzId(),
            $statusTransfer->getParkerId(),
        ]);
    }
}
