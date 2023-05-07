<?php
declare(strict_types=1);

namespace App\Parker\Business\ParkerWriter;

use App\Generated\Transfer\ParkerTransfer;
use App\Generated\Transfer\TicketTransfer;

interface ParkerWriterInterface
{
    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return \App\Generated\Transfer\TicketTransfer
     */
    public function writeParkerAndStatusEntry(ParkerTransfer $parkerTransfer): TicketTransfer;
}
