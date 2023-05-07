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
                ParkerTableMap::COL_LICENSE_PLATE.",".
                ParkerTableMap::COL_FK_LONG_TERM_PARKER.
            ") VALUES (?,?);"
        );

        $insertStatement->execute([
            $parkerTransfer->getLicencePlate(),
            $parkerTransfer->getLongTermParkerId(),
        ]);

        $parkerTransfer->setId(
            (int) $this->getConnection()->lastInsertId()
        );

        return $parkerTransfer;
    }
}
