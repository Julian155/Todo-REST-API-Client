<?php
declare(strict_types=1);

namespace App\Kernel\Business;

abstract class AbstractFacade
{
    /**
     * @var \App\Kernel\Business\AbstractBusinessFactory|null
     */
    public ?AbstractBusinessFactory $factory = null;

    /**
     * @return \App\Kernel\Business\AbstractBusinessFactory
     */
    public function getFactory(): AbstractBusinessFactory
    {
        if (!$this->factory) {
            $this->factory = $this->getFactoryResolver()->resolveFactory($this);
        }

        return $this->factory;
    }

    /**
     * @return void
     */
    public function initFactory(): void
    {
        $this->factory = $this->getFactoryResolver()->resolveFactory($this);
        $this->factory->initDependencyProvider();
        $this->factory->initConfig();
    }

    /**
     * @return \App\Kernel\Business\BusinessFactoryResolver
     */
    protected function getFactoryResolver(): BusinessFactoryResolver
    {
        return new BusinessFactoryResolver();
    }
}
