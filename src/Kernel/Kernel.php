<?php

namespace App\Kernel;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function boot()
    {
        parent::boot();

        $kernelContainer = new Container($this->getContainer());

        AbstractDependencyProvider::setContainer($kernelContainer);
    }
}
