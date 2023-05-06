<?php
declare(strict_types=1);

namespace App\Parker\Communication\Controller;

use App\Kernel\Business\AbstractFacade;
use App\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method \App\Parker\Business\ParkerFacade getFacade()
 */
class CheckInParkerController extends AbstractController
{
    #[Route('/CheckIn/LongTermParker', name: 'Check In Long Term Parker')]
    public function checkInLongTermParker(Request $request): Response
    {
        $this->getFacade()->checkInLongTermParker();
        return new Response();
    }

    #[Route('/CheckOut/ShortTermParker', name: 'Check Out Short Term Parker')]
    public function checkOutShortTermParker(Request $request): Response
    {
        $this->getFacade()->checkOutShortTermParker();
        return new Response();
    }

    #[Route('/CheckOut/LongTermParker', name: 'Check Out Long Term Parker')]
    public function checkOutLongTermParker(Request $request): Response
    {
        $this->getFacade()->checkOutLongTermParker();
        return new Response();
    }


}
