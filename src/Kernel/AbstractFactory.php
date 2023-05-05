<?php
declare(strict_types=1);

namespace App\Kernel;

abstract class AbstractFactory
{
    /**
     * @var \App\Kernel\AbstractConfig|null
     */
    public static ?AbstractConfig $config = null;

    /**
     * @var \App\Kernel\AbstractDependencyProvider|null
     */
    public static ?AbstractDependencyProvider $dependencyProvider = null;

    /**
     * @return \App\Kernel\AbstractConfig
     */
    public function getConfig(): AbstractConfig
    {
        if (!static::$config) {
            static::$config = $this->getConfigResolver()->resolveConfig($this);
        }

        return static::$config;
    }

    /**
     * @return \App\Kernel\ConfigResolver
     */
    protected function getConfigResolver(): ConfigResolver
    {
        return new ConfigResolver();
    }

    /**
     * @return \App\Kernel\AbstractDependencyProvider
     */
    public function getContainer(): AbstractDependencyProvider
    {
        if (!static::$dependencyProvider) {
            static::$dependencyProvider = $this->getContainerResolver()->resolveDependencyProvider($this);
        }

        return static::$dependencyProvider;
    }

    /**
     * @return \App\Kernel\ContainerResolver
     */
    protected function getContainerResolver(): ContainerResolver
    {
        return new ContainerResolver();
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    protected function getDependency(string $serviceName): mixed
    {
        return $this->getContainer()->get($serviceName);
    }
}
