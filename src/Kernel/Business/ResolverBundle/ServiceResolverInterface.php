<?php
declare(strict_types=1);

namespace App\Kernel\Business\ResolverBundle;

interface ServiceResolverInterface
{
    /**
     * @param object|string $callerClass
     *
     * @return object
     */
    public function resolveClass(object|string $callerClass): object;
}
