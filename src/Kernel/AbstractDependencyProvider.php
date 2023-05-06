<?php
declare(strict_types=1);

namespace App\Kernel;

abstract class AbstractDependencyProvider
{
    /**
     * @var \App\Kernel\Container|null
     */
    protected static ?Container $container = null;

    public function __construct()
    {
        static::$container = $this->addBusinessLayerDependencies(static::$container);
        static::$container = $this->addCommunicationLayerDependencies(static::$container);
    }

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addBusinessLayerDependencies(Container $container): Container
    {
        return $container;
    }

    /**
     * @param \App\Kernel\Container $container
     *
     * @return \App\Kernel\Container
     */
    protected function addCommunicationLayerDependencies(Container $container): Container
    {
        return $container;
    }

    /**
     * @param \App\Kernel\Container $container
     *
     * @return void
     */
    public static function setContainer(Container $container): void
    {
        if (!static::$container) {
            static::$container = $container;
        }
    }

    /**
     * @param string $serviceName
     *
     * @return object|null
     */
    public function get(string $serviceName): object|null
    {
        return static::$container->get($serviceName);
    }
}
