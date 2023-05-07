<?php
declare(strict_types=1);

namespace App\CheckIn\Business\CheckInHandler;

use App\Generated\Transfer\ParkerTransfer;
use App\Generated\Transfer\TicketTransfer;

interface CheckInHandlerInterface
{
    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return \App\Generated\Transfer\TicketTransfer
     */
    public function checkInParker(ParkerTransfer $parkerTransfer): TicketTransfer;
}
