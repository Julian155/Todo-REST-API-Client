<?php
declare(strict_types=1);

namespace App\Database\Business;

use App\Kernel\Business\AbstractFacade;

/**
 * @method \App\Database\Business\DatabaseBusinessFactory getFactory()
 */
class DatabaseFacade extends AbstractFacade implements DatabaseFacadeInterface
{
    /**
     * @param string $importFilePath
     *
     * @return void
     */
    public function loadDemoData(string $importFilePath): void
    {
        $this->getFactory()->createDatabaseLoader()->loadDemoData($importFilePath);
    }

    /**
     * @return void
     */
    public function generateTableMaps(): void
    {
        $this->getFactory()->createTableMapGenerator()->generateTableMaps();
    }
}
