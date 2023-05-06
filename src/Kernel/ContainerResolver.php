<?php
declare(strict_types=1);

namespace App\Kernel;

use App\Kernel\Business\ClassResolver\AbstractClassResolver;

class ContainerResolver extends AbstractClassResolver
{
    /**
     * @param object $callerClass
     *
     * @return \App\Kernel\AbstractDependencyProvider|null
     */
    public function resolveDependencyProvider(object $callerClass): ?AbstractDependencyProvider
    {
        /**
         * @var \App\Kernel\AbstractDependencyProvider|null $dependencyProvider
         */
        $dependencyProvider = $this->resolveClassName($callerClass);

        return $dependencyProvider;
    }

    /**
     * @return string
     */
    protected function getClassName(): string
    {
        return 'dependencyProvider';
    }
}
