<?php
declare(strict_types=1);

namespace App\Database\Business\TableMapGenerator;

interface TableMapGeneratorInterface
{
    /**
     * @return void
     */
    public function generateTableMaps(): void;
}
