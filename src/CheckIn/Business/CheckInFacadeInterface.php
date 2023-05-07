<?php
declare(strict_types=1);

namespace App\CheckIn\Business;

use App\Generated\Transfer\ParkerTransfer;
use App\Generated\Transfer\ParkingSpaceTransfer;

interface CheckInFacadeInterface
{
    /**
     * @return \App\Generated\Transfer\ParkingSpaceTransfer
     */
    public function getFreeParkingSpaceCounts(): ParkingSpaceTransfer;

    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return void
     */
    public function checkInParker(ParkerTransfer $parkerTransfer): void;
}
