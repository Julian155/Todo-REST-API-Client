<?php
declare(strict_types=1);

namespace App\Database;

use App\Kernel\AbstractDependencyProvider;
use App\Kernel\Container;

class DatabaseDependencyProvider extends AbstractDependencyProvider
{
    public const TWIG_FACADE = 'FACADE_TWIG';

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addTwigFacade($container);

        return $container;
    }

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addTwigFacade(Container $container): Container
    {
        $container->set(
            static::TWIG_FACADE,
            $container->getLocator()->twig()->facade()
        );

        return $container;
    }
}
