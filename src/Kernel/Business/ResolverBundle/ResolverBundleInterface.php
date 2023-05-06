<?php
declare(strict_types=1);

namespace App\Kernel\Business\ResolverBundle;

interface ResolverBundleInterface
{
    /**
     * @param string $moduleName
     *
     * @return $this
     */
    public function setModuleName(string $moduleName): self;
}
