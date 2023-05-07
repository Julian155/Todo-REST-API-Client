<?php
declare(strict_types=1);

namespace App\Parker\Persistence;

use App\Generated\Transfer\ParkerTransfer;

interface ParkerEntityManagerInterface
{
    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return \App\Generated\Transfer\ParkerTransfer
     */
    public function saveParkerEntry(ParkerTransfer $parkerTransfer): ParkerTransfer;

    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return void
     */
    public function deleteParkerEntry(ParkerTransfer $parkerTransfer): void;
}
