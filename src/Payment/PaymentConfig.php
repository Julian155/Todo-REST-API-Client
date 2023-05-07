<?php
declare(strict_types=1);

namespace App\Payment;

use App\Kernel\AbstractConfig;
use App\Shared\Payment\PaymentConstants;

class PaymentConfig extends AbstractConfig
{
    /**
     * @return int
     */
    public function getPaymentRate(): int
    {
        return $this->get(PaymentConstants::PAYMENT_RATE);
    }

    /**
     * @return float
     */
    public function getPaymentRateAmount(): float
    {
        return $this->get(PaymentConstants::PAYMENT_RATE_AMOUNT);
    }
}
