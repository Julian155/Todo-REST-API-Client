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
     * @return void
     */
    public function loadData(): void
    {
        $this->getFactory()->createDatabaseLoader()->loadDemoData();

        dd('ok');
    }
}
