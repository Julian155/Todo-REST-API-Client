<?php
declare(strict_types=1);

namespace App\ParkingStatus\Business\ParkingStatusWriter;

use App\Generated\Transfer\ParkedCarTransfer;
use App\Generated\Transfer\StatusTransfer;
use App\ParkingStatus\Persistence\ParkingStatusEntityManagerInterface;
use App\ParkingStatus\Persistence\ParkingStatusQueryContainerInterface;

class ParkingStatusWriter implements ParkingStatusWriterInterface
{
    /**
     * @var \App\ParkingStatus\Persistence\ParkingStatusEntityManagerInterface
     */
    private ParkingStatusEntityManagerInterface $entityManager;

    /**
     * @var \App\ParkingStatus\Persistence\ParkingStatusQueryContainerInterface
     */
    private ParkingStatusQueryContainerInterface $queryContainer;

    /**
     * @param \App\ParkingStatus\Persistence\ParkingStatusEntityManagerInterface $entityManager
     * @param \App\ParkingStatus\Persistence\ParkingStatusQueryContainerInterface $queryContainer
     */
    public function __construct(
        ParkingStatusEntityManagerInterface $entityManager,
        ParkingStatusQueryContainerInterface $queryContainer
    ) {
        $this->entityManager = $entityManager;
        $this->queryContainer = $queryContainer;
    }

    /**
     * @param \App\Generated\Transfer\StatusTransfer $statusTransfer
     *
     * @return void
     */
    public function saveParkingStatus(StatusTransfer $statusTransfer): void
    {
        $this->entityManager->saveStatusEntry($statusTransfer);
    }

    /**
     * @param ParkedCarTransfer $parkedCarTransfer
     *
     * @return void
     */
    public function updateParkedSpotInStatus(ParkedCarTransfer $parkedCarTransfer): void
    {
        $parkingStatusEntry = $this->getParkingStatusEntry($parkedCarTransfer->getLicencePlate());
        $parkingStatusEntry->setParkingSpotId($parkedCarTransfer->getParkingSpotId());

        $this->entityManager->updateStatusEntry($parkingStatusEntry);
    }

    /**
     * @param string $licencePlate
     *
     * @return \App\Generated\Transfer\StatusTransfer
     */
    protected function getParkingStatusEntry(string $licencePlate): StatusTransfer
    {
        $statusEntry = $this->queryContainer
            ->queryStatusByParkerLicencePlate($licencePlate)
            ->fetch(\PDO::FETCH_ASSOC);

        return (new StatusTransfer())
            ->fromArray($statusEntry);
    }
}
