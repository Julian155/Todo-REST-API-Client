<?php
declare(strict_types=1);

namespace App\Kernel;

abstract class AbstractFactory
{
    /**
     * @var \App\Kernel\AbstractConfig|null
     */
    public ?AbstractConfig $config = null;

    /**
     * @var \App\Kernel\AbstractDependencyProvider|null
     */
    public ?AbstractDependencyProvider $dependencyProvider = null;

    /**
     * @return \App\Kernel\AbstractConfig
     */
    public function getConfig(): AbstractConfig
    {
        if (!$this->config) {
            $this->config = $this->getConfigResolver()->resolveClass($this);
        }

        return $this->config;
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
        if (!$this->dependencyProvider) {
            $this->dependencyProvider = $this->getContainerResolver()->resolveDependencyProvider($this);
        }

        return $this->dependencyProvider;
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

    /**
     * @return void
     */
    public function initConfig(): void
    {
        $this->config = $this->getConfigResolver()->resolveClass($this);
    }

    /**
     * @return void
     */
    public function initDependencyProvider(): void
    {
        $this->dependencyProvider = $this->getContainerResolver()->resolveDependencyProvider($this);
    }
}
