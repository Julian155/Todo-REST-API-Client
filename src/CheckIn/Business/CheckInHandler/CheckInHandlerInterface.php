<?php
declare(strict_types=1);

namespace App\CheckIn\Business\CheckInHandler;

interface CheckInHandlerInterface
{
    /**
     * @return void
     */
    public function checkInShortTermParker(): void;
}
