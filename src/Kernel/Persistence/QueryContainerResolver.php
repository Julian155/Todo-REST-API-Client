<?php
declare(strict_types=1);

namespace App\Kernel\Persistence;

use App\Kernel\Business\ClassResolver\AbstractClassResolver;
use App\Kernel\Business\ResolverBundle\ServiceResolverInterface;

class QueryContainerResolver extends AbstractClassResolver implements ServiceResolverInterface
{
    /**
     * @param object|string $callerClass
     *
     * @return \App\Kernel\Persistence\AbstractQueryContainer|null
     */
    public function resolveClass(object|string $callerClass): ?AbstractQueryContainer
    {
        /**
         * @var \App\Kernel\Persistence\AbstractQueryContainer|null $queryContainer
         */
        $queryContainer = $this->resolveClassName($callerClass);

        return $queryContainer;
    }

    /**
     * @return string
     */
    protected function getClassName(): string
    {
        return 'queryContainer';
    }
}
