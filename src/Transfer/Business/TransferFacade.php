<?php
declare(strict_types=1);

namespace App\Transfer\Business;

use App\Kernel\Business\AbstractFacade;
use ArrayObject;

/**
 * @method \App\Transfer\Business\TransferBusinessFactory getFactory()
 */
class TransferFacade extends AbstractFacade implements TransferFacadeInterface
{
    /**
     * @return \ArrayObject
     */
    public function getMappedXmlTransfers(): ArrayObject
    {
        return $this->getFactory()->createXmlLoader()->loadXmlTransferFiles();
    }

    /**
     * @param \ArrayObject $mappedXmlTransfers
     * 
     * @return void
     */
    public function createTransfers(ArrayObject $mappedXmlTransfers): void
    {
        $this->getFactory()->createTransferFileWriter()->writeTransferClassDataToFiles($mappedXmlTransfers);
    }

    /**
     * @return void
     */
    public function clearGeneratedDirectory(): void
    {
        $this->getFactory()->createDirectoryFileCleaner()->cleanGeneratedDirectory();
    }
}
