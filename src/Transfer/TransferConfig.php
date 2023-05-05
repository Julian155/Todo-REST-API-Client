<?php
declare(strict_types=1);

namespace App\Transfer;

use App\Kernel\AbstractConfig;
use App\Shared\Kernel\KernelConstants;

class TransferConfig extends AbstractConfig
{
    /**
     * @return string
     */
    public function getApplicationRootDirectory(): string
    {
       return $this->get(KernelConstants::APPLICATION_ROOT_DIR);
    }

    /**
     * @return string
     */
    public function getXsdSchemaPath(): string
    {
        return '/src/Transfer/Templates/schema.xsd';
    }
}
