<?php
declare(strict_types=1);

namespace App\Transfer\Business\TransferFileWriter;

interface TransferFileWriterInterface
{
    public function writeTransferClassDataToFiles(\ArrayObject $mappedXmlTransferObjectCollection): void;
}
