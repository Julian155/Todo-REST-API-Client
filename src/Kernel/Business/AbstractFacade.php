<?php
declare(strict_types=1);

namespace App\Kernel\Business;

use App\Kernel\AbstractFactory;

abstract class AbstractFacade
{
    /**
     * @var \App\Kernel\Business\AbstractBusinessFactory|null
     */
    public static ?AbstractBusinessFactory $factory = null;

    /**
     * @return \App\Kernel\Business\AbstractBusinessFactory
     */
    public function getFactory(): AbstractBusinessFactory
    {
        if (!static::$factory) {
            static::$factory = $this->getFactoryResolver()->resolveFactory($this);
        }

        return static::$factory;
    }

    /**
     * @return \App\Kernel\Business\BusinessFactoryResolver
     */
    protected function getFactoryResolver(): BusinessFactoryResolver
    {
        return new BusinessFactoryResolver();
    }
}
