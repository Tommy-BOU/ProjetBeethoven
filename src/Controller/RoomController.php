<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RoomController extends AbstractController
{
    #[Route('/room', name: 'app_room')]
    public function index(): Response
    {
        return $this->render('room/index.html.twig', [
            'controller_name' => 'RoomController',
        ]);
    }
    #[Route('/room', name: 'app_room_details')]
    public function details(): Response
    {
        return $this->render('room/details.html.twig', [
            'controller_name' => 'RoomController',
        ]);
    }
    
}
