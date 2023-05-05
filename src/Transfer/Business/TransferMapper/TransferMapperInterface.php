<?php
declare(strict_types=1);

namespace App\Transfer\Business\TransferMapper;

use DOMDocument;

interface TransferMapperInterface
{
    public function mapXmlDocumentToArray(DOMDocument $xmlTransferDocument): array;
}
