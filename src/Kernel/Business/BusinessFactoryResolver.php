<?php
declare(strict_types=1);

namespace App\Kernel\Business;

use App\Kernel\Business\ClassResolver\AbstractClassResolver;

class BusinessFactoryResolver extends AbstractClassResolver
{
    /**
     * @param object $callerClass
     *
     * @return \App\Kernel\Business\AbstractBusinessFactory
     */
    public function resolveFactory(object $callerClass): AbstractBusinessFactory
    {

        /**
         * @var \App\Kernel\Business\AbstractBusinessFactory $factory
         */
        $factory = $this->resolveClassName($callerClass);

        return $factory;
    }

    protected function getClassName(): string
    {
        return 'businessFactory';
    }
}
