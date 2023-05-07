<?php
declare(strict_types=1);

namespace App\CheckOut\Business\CheckOutHandler;

use App\Generated\Transfer\PaymentTransfer;
use App\Generated\Transfer\TicketTransfer;
use App\Payment\Business\PaymentFacadeInterface;

class CheckOutHandler implements CheckOutHandlerInterface
{
    /**
     * @var \App\Payment\Business\PaymentFacadeInterface
     */
    private PaymentFacadeInterface $paymentFacade;

    /**
     * @param \App\Payment\Business\PaymentFacadeInterface $paymentFacade
     */
    public function __construct(PaymentFacadeInterface $paymentFacade)
    {
        $this->paymentFacade = $paymentFacade;
    }

    /**
     * @param \App\Generated\Transfer\TicketTransfer $ticketTransfer
     *
     * @return \App\Generated\Transfer\PaymentTransfer
     */
    public function getDeparturePayment(TicketTransfer $ticketTransfer): PaymentTransfer
    {
        return $this->paymentFacade->createPaymentTransfer($ticketTransfer);
    }

    /**
     * @param \App\Generated\Transfer\PaymentTransfer $paymentTransfer
     *
     * @return void
     */
    public function checkOutShortTermParker(PaymentTransfer $paymentTransfer): void
    {

    }

    /**
     * @param \App\Generated\Transfer\PaymentTransfer $paymentTransfer
     *
     * @return void
     */
    public function checkOutLongTermParker(PaymentTransfer $paymentTransfer): void
    {

    }
}
