<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EventController extends AbstractController{
    #[Route('/event/new', name: 'event_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($event);
            $entityManager->flush();
            return $this->redirectToRoute('app_agenda');
        }

        return $this->render('event/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/event/delete/{id}', name: 'event_delete')]
    public function delete(Event $event, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($event);
        $entityManager->flush();
        return $this->redirectToRoute('app_agenda');
    }

    #[Route('/agenda', name: 'app_agenda')]
    public function agenda(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAllEventsOrderedByDate(); // Trier par date croissante
        
        return $this->render('agenda/index.html.twig', [
            'events' => $events, 
        ]);
    }

    #[Route('/event/edit/{id}', name: 'event_edit')]
    public function edit(Event $event, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_agenda');
        }

        return $this->render('event/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
