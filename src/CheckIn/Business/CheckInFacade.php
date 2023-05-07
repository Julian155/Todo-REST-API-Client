<?php
declare(strict_types=1);

namespace App\CheckIn\Business;

use App\Generated\Transfer\ParkerTransfer;
use App\Generated\Transfer\ParkingSpaceTransfer;
use App\Generated\Transfer\TicketTransfer;
use App\Kernel\Business\AbstractFacade;

/**
 * @method \App\CheckIn\Business\CheckInBusinessFactory getFactory()
 */
class CheckInFacade extends AbstractFacade implements CheckInFacadeInterface
{
    /**
     * @return \App\Generated\Transfer\ParkingSpaceTransfer
     */
    public function getFreeParkingSpaceCounts(): ParkingSpaceTransfer
    {
        return $this->getFactory()->createParkingStatusReader()->getFreeParkingSpaces();
    }

    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return \App\Generated\Transfer\TicketTransfer
     */
    public function checkInParker(ParkerTransfer $parkerTransfer): TicketTransfer
    {
        return $this->getFactory()->createCheckInHandler()->checkInParker($parkerTransfer);
    }
}
