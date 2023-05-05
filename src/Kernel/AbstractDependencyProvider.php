<?php
declare(strict_types=1);

namespace App\Kernel;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractDependencyProvider
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface|null
     */
    protected static ?ContainerInterface $container = null;

    public function __construct()
    {
        static::$container = $this->addBusinessLayerDependencies(static::$container);
        static::$container = $this->addCommunicationLayerDependencies(static::$container);
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function addBusinessLayerDependencies(ContainerInterface $container): ContainerInterface
    {
        return $container;
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function addCommunicationLayerDependencies(ContainerInterface $container): ContainerInterface
    {
        return $container;
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     *
     * @return void
     */
    public static function setContainer(ContainerInterface $container): void
    {
        if (!static::$container) {
            static::$container = $container;
        }
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    public function get(string $serviceName): mixed
    {
        return static::$container->get($serviceName);
    }
}
