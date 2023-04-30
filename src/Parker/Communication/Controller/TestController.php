<?php
declare(strict_types=1);

namespace App\Parker\Communication\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckInParker extends AbstractController
{
    #[Route('/CheckIn/ShortTermParker', name: 'Check In Short Term Parker')]
    public function checkInShortTermParker(Request $request): Response
    {
        return new Response();
    }   
    
    #[Route('/CheckIn/LongTermParker', name: 'Check In Long Term Parker')]
    public function checkInLongTermParker(Request $request): Response
    {
        return new Response();
    }   
}
