<?php
declare(strict_types=1);

namespace App\Payment\Business\Calculator;

use App\Generated\Transfer\PaymentTransfer;
use App\Generated\Transfer\TicketTransfer;
use App\Payment\PaymentConfig;
use DateTime;

class PaymentCalculator implements PaymentCalculatorInterface
{
    /**
     * @var \App\Payment\PaymentConfig
     */
    private PaymentConfig $config;

    /**
     * @param \App\Payment\PaymentConfig $config
     */
    public function __construct(PaymentConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \App\Generated\Transfer\TicketTransfer $ticketTransfer
     *
     * @return \App\Generated\Transfer\PaymentTransfer
     */
    public function createPaymentTransfer(TicketTransfer $ticketTransfer): PaymentTransfer
    {
        $departuredDate = new DateTime();
        $arrivedDate = new DateTime($ticketTransfer->getArrivedAt());

        $paymentAmount = $this->calculatePaymentAmount($arrivedDate, $departuredDate);

        return (new PaymentTransfer())
            ->setArrivedAt($ticketTransfer->getArrivedAt())
            ->setDeparturedAt($departuredDate->format('Y-m-d H:m:s'))
            ->setLicencePlate($ticketTransfer->getLicencePlate())
            ->setAmount($paymentAmount);
    }

    /**
     * @param \DateTime $arrivedDate
     * @param \DateTime $departuredDate
     *
     * @return float
     */
    protected function calculatePaymentAmount(DateTime $arrivedDate, DateTime $departuredDate): float
    {
        $baseAmount = $this->config->getPaymentRateAmount();
        $paymentRate = $this->config->getPaymentRate();

        $parkedTime = $arrivedDate->diff($departuredDate)->$paymentRate;

        if (!$parkedTime) {
            return $baseAmount;
        }

        return $baseAmount * $parkedTime;
    }
}
