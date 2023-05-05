<?php
declare(strict_types=1);

namespace App\Transfer\Business\XmlCollector;

interface XmlCollectorInterface
{
    /**
     * @return string[][]
     */
    public function collectXmlTransferFiles(): array;
}
