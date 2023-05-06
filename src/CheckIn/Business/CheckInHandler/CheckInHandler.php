<?php
declare(strict_types=1);

namespace App\CheckIn\Business\CheckInHandler;

use App\Generated\Transfer\ParkerTransfer;
use App\Parker\Business\ParkerFacadeInterface;

class CheckInHandler implements CheckInHandlerInterface
{
    /**
     * @var \App\Parker\Business\ParkerFacadeInterface
     */
    private ParkerFacadeInterface $parkerFacade;

    /**
     * @param \App\Parker\Business\ParkerFacadeInterface $parkerFacade
     */
    public function __construct(ParkerFacadeInterface $parkerFacade)
    {
        $this->parkerFacade = $parkerFacade;
    }

    /**
     * @return void
     */
    public function checkInShortTermParker(): void
    {
        $this->parkerFacade->checkInShortTermParker((new ParkerTransfer()));
    }
}
