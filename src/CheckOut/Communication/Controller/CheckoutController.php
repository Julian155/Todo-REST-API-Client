<?php
declare(strict_types=1);

namespace App\CheckOut\Communication\Controller;

use App\Generated\Transfer\TicketTransfer;
use App\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method \App\CheckOut\Business\CheckOutFacadeInterface getFacade()
 */
class CheckoutController extends AbstractController
{
    #[Route('/CheckOut/ShortTermParker', name: 'Check Out Short Term Parker')]
    public function checkOutShortTermParker(Request $request): Response
    {
        $this->getFacade();

        return new Response();
    }

    #[Route('/CheckOut/LongTermParker', name: 'Check Out Long Term Parker')]
    public function checkOutLongTermParker(Request $request): Response
    {
        $this->getFacade();

        return new Response();
    }

    #[Route('/CheckOut/Price', name: 'Check Out Long Term Parker')]
    public function getCheckoutPrice(Request $request): JsonResponse
    {
        // TODO TICKET DATA COMES FROM REQUEST
        $ticketTransfer = new TicketTransfer();
        $ticketTransfer->setLicencePlate('DV9B78EH');
        $ticketTransfer->setArrivedAt('2023-05-07 11:36:54');

        $paymentTransfer = $this->getFacade()->getDeparturePayment($ticketTransfer);

        return new JsonResponse($paymentTransfer->toArray());
    }
}
