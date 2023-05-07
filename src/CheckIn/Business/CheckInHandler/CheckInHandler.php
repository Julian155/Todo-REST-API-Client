<?php
declare(strict_types=1);

namespace App\CheckIn\Business\CheckInHandler;

use App\Generated\Transfer\ParkerTransfer;
use App\Generated\Transfer\TicketTransfer;
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
     * @param \App\Generated\Transfer\ParkerTransfer $parkerTransfer
     *
     * @return \App\Generated\Transfer\TicketTransfer
     */
    public function checkInParker(ParkerTransfer $parkerTransfer): TicketTransfer
    {
        $parkerTransfer->setLicencePlate($this->createLicense());

        return $this->parkerFacade->checkInParker($parkerTransfer);
    }

    /**
     * Temp test method. Real license string will come from the request
     *
     * @param int $length
     *
     * @return string
     */
    protected function createLicense(int $length = 8): string
    {
        return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', (int)ceil($length / strlen($x)))),1,$length);
    }
}
