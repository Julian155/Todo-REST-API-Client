<?php
declare(strict_types=1);

namespace App\Ide;

use App\Kernel\AbstractConfig;
use App\Shared\Kernel\KernelConstants;

class IdeConfig extends AbstractConfig
{
    /**
     * @return string
     */
    public function getApplicationRootDirectory(): string
    {
        return $this->get(KernelConstants::APPLICATION_ROOT_DIR);
    }
}
