<?php
declare(strict_types=1);

namespace App\Parker\Persistence;

use App\Generated\Transfer\ParkerTransfer;
use App\Generated\Transfer\StatusTransfer;

interface ParkerEntityManagerInterface
{
    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return \App\Generated\Transfer\ParkerTransfer
     */
    public function saveParkerEntry(ParkerTransfer $parkerTransfer): ParkerTransfer;

    /**
     * @param \App\Generated\Transfer\StatusTransfer $statusTransfer
     *
     * @return void
     */
    public function saveStatusEntry(StatusTransfer $statusTransfer): void;
}
