<?php
declare(strict_types=1);

namespace App\CheckIn\Business\ParkingStatusReader;

use App\Generated\Transfer\ParkingSpaceTransfer;
use App\ParkingStatus\Persistence\ParkingStatusQueryContainerInterface;

class ParkingStatusReader implements ParkingStatusReaderInterface
{
    private const MAX_NORMAL_PARKING_SPACES = 140;
    private const MAX_RESERVED_PARKING_SPACES = 40;

    /**
     * @var \App\ParkingStatus\Persistence\ParkingStatusQueryContainerInterface
     */
    private ParkingStatusQueryContainerInterface $parkingStatusQueryContainer;

    /**
     * @param \App\ParkingStatus\Persistence\ParkingStatusQueryContainerInterface $parkingStatusQueryContainer
     */
    public function __construct(ParkingStatusQueryContainerInterface $parkingStatusQueryContainer)
    {
        $this->parkingStatusQueryContainer = $parkingStatusQueryContainer;
    }

    /**
     * @return \App\Generated\Transfer\ParkingSpaceTransfer
     */
    public function getFreeParkingSpaces(): ParkingSpaceTransfer
    {
        $parkingSpaceTransfer = new ParkingSpaceTransfer();

        $freeParkingSpaceCount = $this->parkingStatusQueryContainer
            ->queryFreeNormalParkingSpaces()
            ->fetch(\PDO::FETCH_COLUMN);

        $reservedParkingSpaceCount = $this->parkingStatusQueryContainer
            ->queryReservedParkingSpaces()
            ->fetch(\PDO::FETCH_COLUMN);

        $parkingSpaceTransfer->setFreeNormalParkingSpaces(
            (self::MAX_NORMAL_PARKING_SPACES - $freeParkingSpaceCount)
        );

        $parkingSpaceTransfer->setFreeReservedParkingSpaces(
            (self::MAX_RESERVED_PARKING_SPACES - $reservedParkingSpaceCount)
        );

        return $parkingSpaceTransfer;
    }
}
