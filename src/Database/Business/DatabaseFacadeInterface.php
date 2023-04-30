<?php
declare(strict_types=1);

namespace App\Database\Business;

interface DatabaseFacadeInterface
{
    /**
     * @return void
     */
    public function loadData(): void;
}
