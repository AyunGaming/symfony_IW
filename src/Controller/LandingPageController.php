<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LandingPageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('landing_page/index.html.twig', [
            'title' => 'Bienvenue chez MonBar',
        ]);
    }

    #[Route('/', name: 'homepage')]
    public function event(EventRepository $eventRepository): Response
    {
        $firstEvent = $eventRepository->findOneBy([], ['date' => 'ASC']); 

        return $this->render('landing_page/index.html.twig', [
            'firstEvent' => $firstEvent,
        ]);
    }

}
