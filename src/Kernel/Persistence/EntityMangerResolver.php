<?php
declare(strict_types=1);

namespace App\Kernel\Persistence;

use App\Kernel\Business\ClassResolver\AbstractClassResolver;
use App\Kernel\Business\ResolverBundle\ServiceResolverInterface;

class EntityMangerResolver extends AbstractClassResolver implements ServiceResolverInterface
{
    /**
     * @param object|string $callerClass
     *
     * @return \App\Kernel\Persistence\AbstractEntityManager|null
     */
    public function resolveClass(object|string $callerClass): ?AbstractEntityManager
    {
        /**
         * @var \App\Kernel\Persistence\AbstractEntityManager|null $entityManger
         */
        $entityManger = $this->resolveClassName($callerClass);

        return $entityManger;
    }

    /**
     * @return string
     */
    protected function getClassName(): string
    {
        return 'entityManager';
    }
}
