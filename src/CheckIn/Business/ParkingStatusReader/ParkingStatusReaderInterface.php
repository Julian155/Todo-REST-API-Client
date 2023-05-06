<?php
declare(strict_types=1);

namespace App\CheckIn\Business\ParkingStatusReader;

use App\Generated\Transfer\ParkingSpaceTransfer;

interface ParkingStatusReaderInterface
{
    /**
     * @return \App\Generated\Transfer\ParkingSpaceTransfer
     */
    public function getFreeParkingSpaces(): ParkingSpaceTransfer;
}
