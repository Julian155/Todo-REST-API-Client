<?php
declare(strict_types=1);

namespace App\Kernel\Communication;

use App\Kernel\Business\ClassResolver\AbstractClassResolver;

class CommunicationFactoryResolver extends AbstractClassResolver
{
    /**
     * @param object $callerClass
     *
     * @return \App\Kernel\Communication\AbstractCommunicationFactory
     */
    public function resolveFactory(object $callerClass): AbstractCommunicationFactory
    {
        /**
         * @var \App\Kernel\Communication\AbstractCommunicationFactory $factory
         */
        $factory = $this->resolveClassName($callerClass);

        return $factory;
    }

    /**
     *
     * @return string
     */
    protected function getClassName(): string
    {
        return 'communicationFactory';
    }
}
