<?php
declare(strict_types=1);

namespace App\Kernel;

use ArrayObject;

class Config
{
    /**
     * @var \ArrayObject|null
     */
    protected static ?ArrayObject $config = null;

    /**
     * @var \App\Kernel\Config|null
     */
    protected static ?Config $instance = null;

    /**
     * @return void
     */
    protected static function init(): void
    {
        $config = new ArrayObject();

        self::buildConfig($config, 'default_config.php');

        self::$config = $config;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        if (!static::$config) {
            static::init();
        }

        return static::$config[$key];
    }

    /**
     * @param \ArrayObject $config
     * @param string $configFileName
     *
     * @return \ArrayObject
     */
    protected static function buildConfig(ArrayObject $config, string $configFileName): ArrayObject
    {
        $filePath = sprintf(
            '%s/config/shared/%s',
            dirname(__DIR__, 2),
            $configFileName
        );

        include $filePath;

        return $config;
    }

    /**
     * @return \App\Kernel\Config
     */
    public static function getConfig(): Config
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}
