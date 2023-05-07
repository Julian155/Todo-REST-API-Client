<?php
declare(strict_types=1);

namespace App\ParkingStatus\Business;

use App\Generated\Transfer\ParkedCarTransfer;
use App\Generated\Transfer\StatusTransfer;

interface ParkingStatusFacadeInterface
{
    /**
     * @param \App\Generated\Transfer\StatusTransfer $statusTransfer
     *
     * @return void
     */
    public function saveParkingStatus(StatusTransfer $statusTransfer): void;

    /**
     * @param \App\Generated\Transfer\ParkedCarTransfer $parkedCarTransfer
     *
     * @return void
     */
    public function updateParkedSpotInStatus(ParkedCarTransfer $parkedCarTransfer): void;
}
