<?php
declare(strict_types=1);

namespace App\ParkingStatus\Business\ParkingStatusWriter;

use App\Generated\Transfer\ParkedCarTransfer;
use App\Generated\Transfer\StatusTransfer;

interface ParkingStatusWriterInterface
{
    /**
     * @param ParkedCarTransfer $parkedCarTransfer
     *
     * @return void
     */
    public function updateParkedSpotInStatus(ParkedCarTransfer $parkedCarTransfer): void;

    /**
     * @param \App\Generated\Transfer\StatusTransfer $statusTransfer
     *
     * @return void
     */
    public function saveParkingStatus(StatusTransfer $statusTransfer): void;
}
