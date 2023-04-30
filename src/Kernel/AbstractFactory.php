<?php
declare(strict_types=1);

namespace App\Kernel;

abstract class AbstractFactory
{
    /**
     * @var \App\Kernel\AbstractConfig|null
     */
    public static ?AbstractConfig $config = null;

    /**
     * @return \App\Kernel\AbstractConfig
     */
    public function getConfig(): AbstractConfig
    {
        if (!static::$config) {
            static::$config = $this->getConfigResolver()->resolveConfig($this);
        }

        return static::$config;
    }

    /**
     * @return \App\Kernel\ConfigResolver
     */
    protected function getConfigResolver(): ConfigResolver
    {
        return new ConfigResolver();
    }
}
