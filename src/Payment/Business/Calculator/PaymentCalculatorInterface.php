<?php
declare(strict_types=1);

namespace App\Payment\Business\Calculator;

use App\Generated\Transfer\PaymentTransfer;
use App\Generated\Transfer\TicketTransfer;

interface PaymentCalculatorInterface
{
    /**
     * @param \App\Generated\Transfer\TicketTransfer $ticketTransfer
     *
     * @return \App\Generated\Transfer\PaymentTransfer
     */
    public function createPaymentTransfer(TicketTransfer $ticketTransfer): PaymentTransfer;
}
