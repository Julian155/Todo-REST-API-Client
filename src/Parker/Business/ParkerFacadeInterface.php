<?php
declare(strict_types=1);

namespace App\Parker\Business;

use App\Generated\Transfer\ParkerTransfer;

interface ParkerFacadeInterface
{
    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return void
     */
    public function checkInParker(ParkerTransfer $parkerTransfer): void;
}
