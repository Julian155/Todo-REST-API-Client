<?php
declare(strict_types=1);

namespace App\CheckIn;

use App\Kernel\AbstractDependencyProvider;
use App\Kernel\Container;

class CheckInDependencyProvider extends AbstractDependencyProvider
{
    public const PARKING_STATUS_QUERY_CONTAINER = "QUERY_CONTAINER_PARKING_STATUS";
    public const PARKER_FACADE = "FACADE_PARKER";

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addParkingStatusQueryContainer($container);
        $container = $this->addParkerFacade($container);

        return $container;
    }

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addParkingStatusQueryContainer(Container $container): Container
    {
        $container->set(
            static::PARKING_STATUS_QUERY_CONTAINER,
            $container->getLocator()->parkingStatus()->queryContainer()
        );

        return $container;
    }

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addParkerFacade(Container $container): Container
    {
        $container->set(
            static::PARKER_FACADE,
            $container->getLocator()->parker()->facade()
        );

        return $container;
    }
}
