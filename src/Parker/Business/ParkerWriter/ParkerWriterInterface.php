<?php
declare(strict_types=1);

namespace App\Parker\Business\ParkerWriter;

use App\Generated\Transfer\ParkerTransfer;

interface ParkerWriterInterface
{
    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return void
     */
    public function writeShortTermParkerEntry(ParkerTransfer $parkerTransfer): void;
}
