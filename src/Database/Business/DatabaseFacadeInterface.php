<?php
declare(strict_types=1);

namespace App\Database\Business;

interface DatabaseFacadeInterface
{
    /**
     * @param string $importFilePath
     *
     * @return void
     */
    public function loadDemoData(string $importFilePath): void;
}
