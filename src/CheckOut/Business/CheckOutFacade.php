<?php
declare(strict_types=1);

namespace App\CheckOut\Business;

use App\Generated\Transfer\PaymentTransfer;
use App\Generated\Transfer\TicketTransfer;
use App\Kernel\Business\AbstractFacade;

/**
 * @method \App\CheckOut\Business\CheckOutBusinessFactory getFactory()
 */
class CheckOutFacade extends AbstractFacade implements CheckOutFacadeInterface
{
    /**
     * @param \App\Generated\Transfer\TicketTransfer $ticketTransfer
     *
     * @return \App\Generated\Transfer\PaymentTransfer
     */
    public function getDeparturePayment(TicketTransfer $ticketTransfer): PaymentTransfer
    {
        return $this->getFactory()
            ->createCheckoutHandler()
            ->getDeparturePayment($ticketTransfer);
    }
}
