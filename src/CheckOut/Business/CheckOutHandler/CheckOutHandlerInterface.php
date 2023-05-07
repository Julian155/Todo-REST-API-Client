<?php
declare(strict_types=1);

namespace App\CheckOut\Business\CheckOutHandler;

use App\Generated\Transfer\PaymentTransfer;
use App\Generated\Transfer\TicketTransfer;

interface CheckOutHandlerInterface
{
    /**
     * @param \App\Generated\Transfer\TicketTransfer $ticketTransfer
     *
     * @return \App\Generated\Transfer\PaymentTransfer
     */
    public function getDeparturePayment(TicketTransfer $ticketTransfer): PaymentTransfer;

    /**
     * @param \App\Generated\Transfer\PaymentTransfer $paymentTransfer
     *
     * @return void
     */
    public function checkOutShortTermParker(PaymentTransfer $paymentTransfer): void;

    /**
     * @param \App\Generated\Transfer\PaymentTransfer $paymentTransfer
     *
     * @return void
     */
    public function checkOutLongTermParker(PaymentTransfer $paymentTransfer): void;
}
