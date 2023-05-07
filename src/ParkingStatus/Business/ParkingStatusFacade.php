<?php
declare(strict_types=1);

namespace App\ParkingStatus\Business;

use App\Generated\Transfer\ParkedCarTransfer;
use App\Generated\Transfer\StatusTransfer;
use App\Kernel\Business\AbstractFacade;

/**
 * @method \App\ParkingStatus\Business\ParkingStatusBusinessFactory getFactory()
 */
class ParkingStatusFacade extends AbstractFacade implements ParkingStatusFacadeInterface
{
    /**
     * @param \App\Generated\Transfer\StatusTransfer $statusTransfer
     *
     * @return void
     */
    public function saveParkingStatus(StatusTransfer $statusTransfer): void
    {
        $this->getFactory()
            ->createParkingStatusWriter()
            ->saveParkingStatus($statusTransfer);
    }

    /**
     * @param \App\Generated\Transfer\ParkedCarTransfer $parkedCarTransfer
     *
     * @return void
     */
    public function updateParkedSpotInStatus(ParkedCarTransfer $parkedCarTransfer): void
    {
        $this->getFactory()
            ->createParkingStatusWriter()
            ->updateParkedSpotInStatus($parkedCarTransfer);
    }

    /**
     * @param \App\Generated\Transfer\StatusTransfer $statusTransfer
     *
     * @return void
     */
    public function deleteParkingStatus(StatusTransfer $statusTransfer): void
    {
        $this->getFactory()
            ->getEntityManager()
            ->deleteStatusEntry($statusTransfer);
    }
}
