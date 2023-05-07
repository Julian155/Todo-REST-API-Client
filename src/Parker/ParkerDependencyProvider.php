<?php
declare(strict_types=1);

namespace App\Parker;

use App\Kernel\AbstractDependencyProvider;
use App\Kernel\Container;

class ParkerDependencyProvider extends AbstractDependencyProvider
{
    public const PARKING_STATUS_FACADE = 'FACADE_PARKING_STATUS';

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addParkingStatusFacade($container);

        return $container;
    }

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addParkingStatusFacade(Container $container): Container
    {
        $container->set(
            static::PARKING_STATUS_FACADE,
            $container->getLocator()->parkingStatus()->facade()
        );

        return $container;
    }
}
