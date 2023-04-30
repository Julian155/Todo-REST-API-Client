<?php
declare(strict_types=1);

namespace App\Kernel\Business;

use App\Kernel\Business\ClassResolver\AbstractClassResolver;
use App\Kernel\Business\ClassResolver\ResolvableClass;

class FacadeResolver extends AbstractClassResolver
{
    /**
     * @param object $callerClass
     *
     * @return \App\Kernel\Business\AbstractFacade
     */
    public function resolveFacade(object $callerClass): AbstractFacade
    {
        /**
         * @var \App\Kernel\Business\AbstractFacade $facade
         */
        $facade = $this->resolveClassName($callerClass);

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
