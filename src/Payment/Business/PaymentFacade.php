<?php
declare(strict_types=1);

namespace App\Payment\Business;

use App\Generated\Transfer\PaymentTransfer;
use App\Generated\Transfer\TicketTransfer;
use App\Kernel\Business\AbstractFacade;

/**
 * @method \App\Payment\Business\PaymentBusinessFactory getFactory()
 */
class PaymentFacade extends AbstractFacade implements PaymentFacadeInterface
{
    /**
     * @param \App\Generated\Transfer\TicketTransfer $ticketTransfer
     *
     * @return \App\Generated\Transfer\PaymentTransfer
     */
    public function createPaymentTransfer(TicketTransfer $ticketTransfer): PaymentTransfer
    {
        return $this->getFactory()
            ->createPaymentCalculator()
            ->createPaymentTransfer($ticketTransfer);
    }
}

