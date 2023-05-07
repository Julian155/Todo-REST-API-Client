<?php
declare(strict_types=1);

namespace App\CheckIn\Communication\Controller;

use App\Generated\Transfer\ParkerTransfer;
use App\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method \App\CheckIn\Business\CheckInFacadeInterface getFacade()
 */
class CheckInController extends AbstractController
{
    #[Route('/', name:'getFreeParkingSpaceCount')]
    public function getFreeParkingSpaceCount(Request $request): JsonResponse
    {
        $parkingSpaceTransfer = $this->getFacade()->getFreeParkingSpaceCounts();

        return new JsonResponse($parkingSpaceTransfer->toArray());
    }

    #[Route('/CheckIn/ShortTermParker', name: 'Check In Short Term Parker')]
    public function checkInShortTermParker(Request $request): JsonResponse
    {
        $parkerTransfer = new ParkerTransfer();

        $ticketTransfer = $this->getFacade()->checkInParker($parkerTransfer);

        return new JsonResponse($ticketTransfer->toArray());
    }

    #[Route('/CheckIn/LongTermParker', name: 'Check In Long Term Parker')]
    public function checkInLongTermParker(Request $request): JsonResponse
    {
        $parkerTransfer = new ParkerTransfer();
        // TODO: Id will come from request
        $parkerTransfer->setLongTermParkerId(1);

        $ticketTransfer = $this->getFacade()->checkInParker($parkerTransfer);

        return new JsonResponse($ticketTransfer->toArray());
    }
}
