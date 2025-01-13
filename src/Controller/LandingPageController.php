<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LandingPageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('landing_page/index.html.twig', [
            'title' => 'Bienvenue chez MonBar',
        ]);
    }

    #[Route('/menu', name: 'menu')]
    public function menu(): Response
    {
        return $this->render('menu/index.html.twig', [
            'title' => 'Notre Menu',
        ]);
    }

    #[Route('/reservation', name: 'reservation')]
    public function reservation(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'title' => 'Réservez une Table',
        ]);
    }

    #[Route('/agenda', name: 'agenda')]
    public function agenda(): Response
    {
        return $this->render('agenda/index.html.twig', [
            'title' => 'Agenda des Événements',
        ]);
    }
}
