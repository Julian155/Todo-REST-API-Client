<?php
declare(strict_types=1);

namespace App\Parker\Business;

use App\Kernel\Business\AbstractBusinessFactory;
use App\Kernel\Business\AbstractFacade;

/**
 * @method \App\Parker\Business\ParkerBusinessFactory getFactory()
 */
class ParkerFacade extends AbstractFacade implements ParkerFacadeInterface
{
    public function checkInParker()
    {
        $this->getFactory()->createParkerWriter()->writeParkerInstance();
    }
}
