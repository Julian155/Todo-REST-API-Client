<?php
declare(strict_types=1);

namespace App\Twig\Business\DirectoryFileCleaner;

interface DirectoryFileCleanerInterface
{
    /**
     * @param string $folderName
     *
     * @return void
     */
    public function cleanGeneratedDirectory(string $folderName): void;
}
