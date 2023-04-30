<?php
declare(strict_types=1);

namespace App\Kernel;

class AbstractConfig
{
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $this->getConfig()->get($key);
    }

    /**
     * @return \App\Kernel\Config
     */
    protected function getConfig(): Config
    {
        return Config::getConfig();
    }
}
