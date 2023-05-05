<?php
declare(strict_types=1);

namespace App\Transfer\Business\DirectoryFileCleaner;

interface DirectoryFileCleanerInterface
{
    /**
     * @return void
     */
    public function cleanGeneratedDirectory(): void;
}
