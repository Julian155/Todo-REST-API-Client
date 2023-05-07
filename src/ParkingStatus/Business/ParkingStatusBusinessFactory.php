<?php
declare(strict_types=1);

namespace App\ParkingStatus\Business;

use App\Kernel\Business\AbstractBusinessFactory;
use App\ParkingStatus\Business\ParkingStatusWriter\ParkingStatusWriter;
use App\ParkingStatus\Business\ParkingStatusWriter\ParkingStatusWriterInterface;

/**
 * @method \App\ParkingStatus\Persistence\ParkingStatusEntityManagerInterface getEntityManager()
 * @method \App\ParkingStatus\Persistence\ParkingStatusQueryContainerInterface getQueryContainer()
 */
class ParkingStatusBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \App\ParkingStatus\Business\ParkingStatusWriter\ParkingStatusWriterInterface
     */
    public function createParkingStatusWriter(): ParkingStatusWriterInterface
    {
        return new ParkingStatusWriter(
            $this->getEntityManager(),
            $this->getQueryContainer()
        );
    }
}
