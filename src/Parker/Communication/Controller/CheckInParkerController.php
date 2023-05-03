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
    #[Route('/CheckIn/ShortTermParker', name: 'Check In Short Term Parker')]
    public function checkInShortTermParker(Request $request): Response
    {
        $this->getFacade()->checkInShortTermParker();
        return new Response();
    }   
    
    #[Route('/CheckIn/LongTermParker', name: 'Check In Long Term Parker')]
    public function checkInLongTermParker(Request $request): Response
    {
        $this->getFacade()->checkInLongTermParker();
        return new Response();
    }

}
