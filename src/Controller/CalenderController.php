<?php

namespace App\Controller;

use App\Repository\CalendarRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalenderController extends AbstractController
{
    #[Route('/calender', name: 'app_calender')]
    public function index(CalendarRepository $calendar): Response
    {
         $events = $calendar->findAll();

        $rdvs=[];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor(),
                'allDay' => $event->getAllDay(),
            ];

        }
        $data = json_encode($rdvs);

        return $this->render('calender/index.html.twig', compact('data'));
    }
}
