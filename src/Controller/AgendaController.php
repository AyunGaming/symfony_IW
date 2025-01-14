<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AgendaController extends AbstractController{
    #[Route('/agenda', name: 'app_agenda')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findBy(['date' => new \DateTimeImmutable()], ['date' => 'ASC']);
        return $this->render('agenda/index.html.twig', [
            'events' => $events,
        ]);
    }
}
