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
    public function checkInShortTermParker(): void
    {
        $this->getFactory()->createParkerWriter()->writeShortTermParkerCheckInEntry();
    }

    public function checkInLongTermParker(): void
    {
        $this->getFactory()->createParkerWriter()->writeLongTermParkerCheckInEntry();
    }


    public function checkOutShortTermParker(): void
    {
        $this->getFactory()->createParkerWriter()->writeShortTermParkerCheckOutEntry();
    }

    public function checkOutLongTermParker(): void
    {
        $this->getFactory()->createParkerWriter()->writeLongTermParkerCheckOutEntry();
    }
}
