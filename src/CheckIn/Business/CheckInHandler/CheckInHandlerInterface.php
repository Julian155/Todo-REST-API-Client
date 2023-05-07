<?php
declare(strict_types=1);

namespace App\CheckIn\Business\CheckInHandler;

use App\Generated\Transfer\ParkerTransfer;

interface CheckInHandlerInterface
{
    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return void
     */
    public function checkInParker(ParkerTransfer $parkerTransfer): void;
}
