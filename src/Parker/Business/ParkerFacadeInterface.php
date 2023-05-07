<?php
declare(strict_types=1);

namespace App\Parker\Business;

use App\Generated\Transfer\ParkerTransfer;
use App\Generated\Transfer\TicketTransfer;

interface ParkerFacadeInterface
{
    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return \App\Generated\Transfer\TicketTransfer
     */
    public function checkInParker(ParkerTransfer $parkerTransfer): TicketTransfer;

    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return void
     */
    public function deleteParker(ParkerTransfer $parkerTransfer): void;
}
