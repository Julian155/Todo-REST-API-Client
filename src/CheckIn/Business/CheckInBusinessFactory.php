<?php
declare(strict_types=1);

namespace App\CheckIn\Business;

use App\CheckIn\Business\CheckInHandler\CheckInHandler;
use App\CheckIn\Business\CheckInHandler\CheckInHandlerInterface;
use App\CheckIn\Business\ParkingStatusReader\ParkingStatusReader;
use App\CheckIn\Business\ParkingStatusReader\ParkingStatusReaderInterface;
use App\CheckIn\CheckInDependencyProvider;
use App\Kernel\Business\AbstractBusinessFactory;
use App\Parker\Business\ParkerFacadeInterface;
use App\ParkingStatus\Persistence\ParkingStatusQueryContainerInterface;

class CheckInBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \App\CheckIn\Business\ParkingStatusReader\ParkingStatusReaderInterface
     */
    public function createParkingStatusReader(): ParkingStatusReaderInterface
    {
        return new ParkingStatusReader(
            $this->getParkingStatusQueryContainer()
        );
    }

    /**
     * @return \App\CheckIn\Business\CheckInHandler\CheckInHandlerInterface
     */
    public function createCheckInHandler(): CheckInHandlerInterface
    {
        return new CheckInHandler(
            $this->getParkerFacade()
        );
    }

    /**
     * @return \App\Parker\Business\ParkerFacadeInterface
     */
    public function getParkerFacade(): ParkerFacadeInterface
    {
        return $this->getDependency(CheckInDependencyProvider::PARKER_FACADE);
    }

    /**
     * @return \App\ParkingStatus\Persistence\ParkingStatusQueryContainerInterface
     */
    public function getParkingStatusQueryContainer(): ParkingStatusQueryContainerInterface
    {
        return $this->getDependency(CheckInDependencyProvider::PARKING_STATUS_QUERY_CONTAINER);
    }
}
