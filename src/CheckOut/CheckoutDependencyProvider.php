<?php
declare(strict_types=1);

namespace App\CheckOut;

use App\Kernel\AbstractDependencyProvider;
use App\Kernel\Container;

class CheckoutDependencyProvider extends AbstractDependencyProvider
{
    public const PAYMENT_FACADE = "FACADE_PAYMENT";

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addPaymentFacade($container);

        return $container;
    }

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addPaymentFacade(Container $container): Container
    {
        $container->set(
            static::PAYMENT_FACADE,
            $container->getLocator()->payment()->facade()
        );

        return $container;
    }
}
