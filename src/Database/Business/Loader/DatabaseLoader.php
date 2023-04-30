<?php
declare(strict_types=1);

namespace App\Database\Business\Loader;

use App\Database\ConnectionTrait;

class DatabaseLoader
{
    use ConnectionTrait;

    /**
     * @return void
     */
    public function loadDemoData(): void
    {
        return;
    }
}
