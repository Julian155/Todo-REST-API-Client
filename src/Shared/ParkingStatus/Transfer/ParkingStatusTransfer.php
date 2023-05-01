<?php
declare(strict_types=1);

namespace App\Shared\ParkingStatus\Transfer;

class ParkingStatusTransfer
{
    /**
     * @var int|null
     */
    private ?int $remainingNormalSpots = null;

    /**
     * @var int|null
     */
    private ?int $remainingReservedSpots = null;

    /**
     * @return int|null
     */
    public function getRemainingNormalSpots(): ?int
    {
        return $this->remainingNormalSpots;
    }

    /**
     * @param int|null $remainingNormalSpots
     */
    public function setRemainingNormalSpots(?int $remainingNormalSpots): void
    {
        $this->remainingNormalSpots = $remainingNormalSpots;
    }

    /**
     * @return int|null
     */
    public function getRemainingReservedSpots(): ?int
    {
        return $this->remainingReservedSpots;
    }

    /**
     * @param int|null $remainingReservedSpots
     */
    public function setRemainingReservedSpots(?int $remainingReservedSpots): void
    {
        $this->remainingReservedSpots = $remainingReservedSpots;
    }
}
