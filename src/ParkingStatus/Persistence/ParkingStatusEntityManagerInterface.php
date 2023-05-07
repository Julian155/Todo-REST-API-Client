<?php
declare(strict_types=1);

namespace App\ParkingStatus\Persistence;

use App\Generated\Transfer\StatusTransfer;

interface ParkingStatusEntityManagerInterface
{
    /**
     * @param \App\Generated\Transfer\StatusTransfer $statusTransfer
     *
     * @return void
     */
    public function saveStatusEntry(StatusTransfer $statusTransfer): void;

    /**
     * @param \App\Generated\Transfer\StatusTransfer $statusTransfer
     *
     * @return void
     */
    public function updateStatusEntry(StatusTransfer $statusTransfer): void;
}
