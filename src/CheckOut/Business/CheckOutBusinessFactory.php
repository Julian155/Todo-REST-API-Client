<?php
declare(strict_types=1);

namespace App\CheckOut\Business;

use App\CheckOut\Business\CheckOutHandler\CheckOutHandler;
use App\CheckOut\Business\CheckOutHandler\CheckOutHandlerInterface;
use App\CheckOut\CheckoutDependencyProvider;
use App\Kernel\Business\AbstractBusinessFactory;
use App\Payment\Business\PaymentFacadeInterface;

class CheckOutBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \App\CheckOut\Business\CheckOutHandler\CheckOutHandlerInterface
     */
    public function createCheckoutHandler(): CheckOutHandlerInterface
    {
        return new CheckOutHandler(
            $this->getPaymentFacade()
        );
    }

    /**
     * @return \App\Payment\Business\PaymentFacadeInterface
     */
    protected function getPaymentFacade(): PaymentFacadeInterface
    {
        return $this->getDependency(CheckoutDependencyProvider::PAYMENT_FACADE);
    }
}
