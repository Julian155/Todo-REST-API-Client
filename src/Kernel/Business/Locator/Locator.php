<?php
declare(strict_types=1);

namespace App\Kernel\Business\Locator;

use App\Generated\Ide\AutoCompleteInterface;
use App\Kernel\Business\FacadeResolver;
use App\Kernel\Business\ResolverBundle\ResolverBundle;
use App\Kernel\Business\ResolverBundle\ResolverBundleInterface;
use App\Kernel\ConfigResolver;
use App\Kernel\Persistence\QueryContainerResolver;

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
     * @return \App\Kernel\Business\ResolverBundle\ResolverBundleInterface
     */
    protected function getResolverBundle(): ResolverBundleInterface
    {
        if (!static::$resolverBundle) {
            static::$resolverBundle = new ResolverBundle([
                'facade' => new FacadeResolver(),
                'config' => new ConfigResolver(),
                'queryContainer' => new QueryContainerResolver(),
            ]);
        }

        return static::$resolverBundle;
    }
}
