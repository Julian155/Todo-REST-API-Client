<?php
declare(strict_types=1);

namespace App\Kernel\Business;

use App\Kernel\Business\ClassResolver\AbstractClassResolver;
use App\Kernel\Business\ResolverBundle\ServiceResolverInterface;

class FacadeResolver extends AbstractClassResolver implements ServiceResolverInterface
{
    /**
     * @param object|string $callerClass
     *
     * @return \App\Kernel\Business\AbstractFacade|null
     */
    public function resolveClass(object|string $callerClass): ?AbstractFacade
    {
        /**
         * @var \App\Kernel\Business\AbstractFacade|null $facade
         */
        $facade = $this->resolveClassName($callerClass);

        if (!$facade) {
            return $facade;
        }

        $facade->initFactory();

        return $facade;
    }

    /**
     * @return string
     */
    protected function getClassName(): string
    {
        return 'facade';
    }
}
