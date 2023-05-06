<?php
declare(strict_types=1);

namespace App\CheckIn\Business;

use App\Generated\Transfer\ParkingSpaceTransfer;

interface CheckInFacadeInterface
{
    /**
     * @return \App\Generated\Transfer\ParkingSpaceTransfer
     */
    public function getFreeParkingSpaceCounts(): ParkingSpaceTransfer;

    /**
     * @return void
     */
    public function checkInShortTermParker(): void;
}
