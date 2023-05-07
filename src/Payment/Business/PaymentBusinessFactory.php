<?php
declare(strict_types=1);

namespace App\Payment\Business;

use App\Kernel\Business\AbstractBusinessFactory;
use App\Payment\Business\Calculator\PaymentCalculator;
use App\Payment\Business\Calculator\PaymentCalculatorInterface;

/**
 * @method \App\Payment\PaymentConfig getConfig()
 */
class PaymentBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \App\Payment\Business\Calculator\PaymentCalculatorInterface
     */
    public function createPaymentCalculator(): PaymentCalculatorInterface
    {
       return new PaymentCalculator(
           $this->getConfig()
       );
    }
}
