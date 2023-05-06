<?php
declare(strict_types=1);

namespace App\Kernel\Business\Locator;

use App\Generated\Ide\AutoCompleteInterface;
use App\Kernel\Business\FacadeResolver;
use App\Kernel\Business\ResolverBundle\ResolverBundle;
use App\Kernel\ConfigResolver;

class Locator implements AutoCompleteInterface
{
    protected static ?ResolverBundle $resolverBundle = null;

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return object
     */
    public function __call(string $name, array $arguments): object
    {
        return $this->getResolverBundle()->setModuleName($name);
    }

    /**
     * @return \App\Kernel\Business\ResolverBundle\ResolverBundle
     */
    protected function getResolverBundle(): ResolverBundle
    {
        if (!static::$resolverBundle) {
            static::$resolverBundle = new ResolverBundle([
                'facade' => new FacadeResolver(),
                'config' => new ConfigResolver(),
            ]);
        }

        return static::$resolverBundle;
    }
}
