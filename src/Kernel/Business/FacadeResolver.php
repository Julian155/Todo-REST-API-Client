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
     * @return \App\Kernel\Business\AbstractFacade
     */
    public function resolveClass(object|string $callerClass): AbstractFacade
    {
        /**
         * @var \App\Kernel\Business\AbstractFacade $facade
         */
        $facade = $this->resolveClassName($callerClass);
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
