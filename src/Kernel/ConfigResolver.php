<?php
declare(strict_types=1);

namespace App\Kernel;

use App\Kernel\Business\ClassResolver\AbstractClassResolver;
use App\Kernel\Business\ResolverBundle\ServiceResolverInterface;

class ConfigResolver extends AbstractClassResolver implements ServiceResolverInterface
{
    /**
     * @param object|string $callerClass
     *
     * @return \App\Kernel\AbstractConfig|null
     */
    public function resolveClass(object|string $callerClass): ?AbstractConfig
    {
        /**
         * @var \App\Kernel\AbstractConfig|null $config
         */
        $config = $this->resolveClassName($callerClass);

        return $config;
    }

    /**
     * @return string
     */
    protected function getClassName(): string
    {
        return 'config';
    }
}
