<?php
declare(strict_types=1);

namespace App\Parker\Business;

use App\Generated\Transfer\ParkerTransfer;
use App\Generated\Transfer\TicketTransfer;
use App\Kernel\Business\AbstractFacade;

/**
 * @method \App\Parker\Business\ParkerBusinessFactory getFactory()
 */
class ParkerFacade extends AbstractFacade implements ParkerFacadeInterface
{
    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return \App\Generated\Transfer\TicketTransfer
     */
    public function checkInParker(ParkerTransfer $parkerTransfer): TicketTransfer
    {
        return $this->getFactory()
            ->createParkerWriter()
            ->writeParkerAndStatusEntry($parkerTransfer);
    }

    public function checkInLongTermParker(): void
    {
        $this->getFactory()->createParkerWriter()->writeLongTermParkerCheckInEntry();
    }


    public function checkOutShortTermParker(): void
    {
        $this->getFactory()->createParkerWriter()->writeShortTermParkerCheckOutEntry();
    }

    public function checkOutLongTermParker(): void
    {
        $this->getFactory()->createParkerWriter()->writeLongTermParkerCheckOutEntry();
    }
}
