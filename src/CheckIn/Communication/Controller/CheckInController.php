<?php
declare(strict_types=1);

namespace App\CheckIn\Communication\Controller;

use App\Generated\Transfer\ParkerTransfer;
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
        $parkerTransfer = new ParkerTransfer();

        $this->getFacade()->checkInParker($parkerTransfer);

        return new Response();
    }

    #[Route('/CheckIn/LongTermParker', name: 'Check In Long Term Parker')]
    public function checkInLongTermParker(Request $request): Response
    {
        $parkerTransfer = new ParkerTransfer();
        // TODO: Id will come from request
        $parkerTransfer->setLongTermParkerId(1);

        $this->getFacade()->checkInParker($parkerTransfer);

        return new Response();
    }
}
