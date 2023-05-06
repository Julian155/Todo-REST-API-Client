<?php
declare(strict_types=1);

namespace App\Kernel;

use App\Kernel\Business\Locator\Locator;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Container
{
    /**
     * @var \App\Kernel\Business\Locator\Locator|null
     */
    protected static ?Locator $locator = null;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $serviceName
     *
     * @return object|null
     */
    public function get(string $serviceName): null|object
    {
        return $this->container->get($serviceName);
    }

    /**
     * @param string $serviceName
     * @param object $serviceClass
     *
     * @return void
     */
    public function set(string $serviceName, object $serviceClass): void
    {
        $this->container->set($serviceName, $serviceClass);
    }

    /**
     * @return \App\Kernel\Business\Locator\Locator
     */
    public function getLocator(): Locator
    {
        if (!static::$locator) {
            static::$locator = new Locator();
        }

        return static::$locator;
    }
}
