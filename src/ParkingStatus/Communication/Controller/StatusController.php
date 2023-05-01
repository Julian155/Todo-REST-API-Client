<?php
declare(strict_types=1);

namespace App\ParkingStatus\Communication\Controller;

use App\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method \App\ParkingStatus\Business\ParkingStatusFacadeInterface getFacade()
 */
class StatusController extends AbstractController
{
    #[Route('/parking/status', name: 'Get Number of remaining Parking Spots')]
    public function getRemainingParkingSpots(Request $request): JsonResponse
    {

    }
}
