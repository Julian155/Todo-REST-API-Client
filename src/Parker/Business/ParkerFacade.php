<?php
declare(strict_types=1);

namespace App\Parker\Business;

use App\Generated\Transfer\ParkerTransfer;
use App\Kernel\Business\AbstractFacade;

/**
 * @method \App\Parker\Business\ParkerBusinessFactory getFactory()
 */
class ParkerFacade extends AbstractFacade implements ParkerFacadeInterface
{
    /**
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return void
     */
    public function checkInShortTermParker(ParkerTransfer $parkerTransfer): void
    {
        $this->getFactory()
            ->createParkerWriter()
            ->writeShortTermParkerEntry($parkerTransfer);
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
