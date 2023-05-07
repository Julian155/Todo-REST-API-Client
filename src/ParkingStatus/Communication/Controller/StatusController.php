<?php
declare(strict_types=1);

namespace App\ParkingStatus\Communication\Controller;

use App\Generated\Transfer\ParkedCarTransfer;
use App\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method \App\ParkingStatus\Business\ParkingStatusFacadeInterface getFacade()
 */
class StatusController extends AbstractController
{
    protected const KEY_LICENCE_PLATE = 'licencePlate';
    protected const KEY_PARKING_SPOT_ID = 'parkingSpotId';

    #[Route(
        '/Status/CarParking',
        name: 'status_update_parking',
    )]
    public function editStatusEntryWithParkedCar(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        $parkedCarTransfer = (new ParkedCarTransfer())
            ->setLicencePlate($requestData[self::KEY_LICENCE_PLATE])
            ->setParkingSpotId($requestData[self::KEY_PARKING_SPOT_ID]);

        return new Response($request->getContent());
    }

    #[Route(
        '/test2',
        name: 'test2',
    )]
    public function test(Request $request): Response
    {
        $parkedCarTransfer = (new ParkedCarTransfer())
            ->setLicencePlate('DV9B78EH')
            ->setParkingSpotId(2);

        $this->getFacade()->updateParkedSpotInStatus($parkedCarTransfer);

        return new Response();
    }
}
