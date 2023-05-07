<?php
declare(strict_types=1);

namespace App\CheckOut\Business;

use App\Generated\Transfer\PaymentTransfer;
use App\Generated\Transfer\TicketTransfer;

interface CheckOutFacadeInterface
{
    /**
     * @param \App\Generated\Transfer\TicketTransfer $ticketTransfer
     *
     * @return \App\Generated\Transfer\PaymentTransfer
     */
    public function getDeparturePayment(TicketTransfer $ticketTransfer): PaymentTransfer;
}
