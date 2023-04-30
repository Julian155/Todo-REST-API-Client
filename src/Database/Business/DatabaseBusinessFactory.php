<?php
declare(strict_types=1);

namespace App\Database\Business;

use App\Database\Business\Loader\DatabaseLoader;
use App\Kernel\Business\AbstractBusinessFactory;

class DatabaseBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \App\Database\Business\Loader\DatabaseLoader
     */
    public function createDatabaseLoader(): DatabaseLoader
    {
        return new DatabaseLoader();
    }
}
