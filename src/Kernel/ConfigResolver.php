<?php
declare(strict_types=1);

namespace App\Kernel;

use App\Kernel\Business\ClassResolver\AbstractClassResolver;

class ConfigResolver extends AbstractClassResolver
{
    /**
     * @param object $callerClass
     *
     * @return \App\Kernel\AbstractConfig
     */
    public function resolveConfig(object $callerClass): AbstractConfig
    {
        /**
         * @var \App\Kernel\AbstractConfig $config
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
