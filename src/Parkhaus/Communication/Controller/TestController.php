<?php
declare(strict_types=1);

namespace App\Parkhaus\Communication\Controller;

use App\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function test(Request $request): Response
    {
        return new Response();
    }
}
