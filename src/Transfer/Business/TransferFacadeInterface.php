<?php
declare(strict_types=1);

namespace App\Transfer\Business;

use \ArrayObject;

interface TransferFacadeInterface
{
    /**
     * @return \ArrayObject
     */
    public function getMappedXmlTransfers(): ArrayObject;

    /**
     * @return void
     */
    public function createTransfers(ArrayObject $mappedXmlTransfers): void;

    /**
     * @return void
     */
    public function clearGeneratedDirectory(): void;
}
