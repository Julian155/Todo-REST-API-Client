<?php
declare(strict_types=1);

namespace App\Ide\Business\ModuleServicesCollector;

interface ModuleServicesCollectorInterface
{
    /**
     * @return string[][]
     */
    public function collectModuleServices(): array;
}
