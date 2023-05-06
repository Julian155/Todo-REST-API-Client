<?php
declare(strict_types=1);

namespace App\Kernel;

use App\Kernel\Persistence\AbstractEntityManager;
use App\Kernel\Persistence\AbstractQueryContainer;
use App\Kernel\Persistence\EntityMangerResolver;
use App\Kernel\Persistence\QueryContainerResolver;

abstract class AbstractFactory
{
    /**
     * @var \App\Kernel\AbstractConfig|null
     */
    private ?AbstractConfig $config = null;

    /**
     * @var \App\Kernel\AbstractDependencyProvider|null
     */
    private ?AbstractDependencyProvider $dependencyProvider = null;

    /**
     * @var \App\Kernel\Persistence\AbstractQueryContainer|null
     */
    private ?AbstractQueryContainer $queryContainer = null;

    /**
     * @var \App\Kernel\Persistence\AbstractEntityManager|null
     */
    private ?AbstractEntityManager $entityManager = null;

    /**
     * @return \App\Kernel\Persistence\AbstractEntityManager
     */
    public function getEntityManager(): AbstractEntityManager
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->getEntityManagerResolver()->resolveClass($this);
        }

        return $this->entityManager;
    }

    /**
     * @return \App\Kernel\Persistence\EntityMangerResolver
     */
    protected function getEntityManagerResolver(): EntityMangerResolver
    {
        return new EntityMangerResolver();
    }

    /**
     * @return \App\Kernel\Persistence\AbstractQueryContainer
     */
    public function getQueryContainer(): AbstractQueryContainer
    {
        if (!$this->queryContainer) {
            $this->queryContainer = $this->getQueryContainerResolver()->resolveClass($this);
        }

        return $this->queryContainer;
    }

    /**
     * @return \App\Kernel\Persistence\QueryContainerResolver
     */
    protected function getQueryContainerResolver(): QueryContainerResolver
    {
        return new QueryContainerResolver();
    }

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

    /**
     * @return void
     */
    public function initEntityManager(): void
    {
        $this->entityManager = $this->getEntityManagerResolver()->resolveClass($this);
    }

    /**
     * @return void
     */
    public function initQueryContainer(): void
    {
        $this->queryContainer = $this->getQueryContainerResolver()->resolveClass($this);
    }
}
