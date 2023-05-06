<?php
declare(strict_types=1);

namespace App\CheckIn\Communication\Controller;

use App\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method \App\CheckIn\Business\CheckInFacadeInterface getFacade()
 */
class CheckInController extends AbstractController
{
    #[Route('/', name:'getFreeParkingSpaceCount')]
    public function getFreeParkingSpaceCount(Request $request): Response
    {
        $parkingSpaceTransfer = $this->getFacade()->getFreeParkingSpaceCounts();

        return new JsonResponse($parkingSpaceTransfer->toArray());
    }

    #[Route('/CheckIn/ShortTermParker', name: 'Check In Short Term Parker')]
    public function checkInShortTermParker(Request $request): Response
    {
        $this->getFacade()->checkInShortTermParker();

        return new Response();
    }
}
