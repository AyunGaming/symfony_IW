<?php

namespace App\Controller;

use App\Entity\Bookings;
use App\Form\BookingsType;
use App\Repository\BookingsRepository;
use App\Repository\TablesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/bookings')]
final class BookingsController extends AbstractController{
    #[Route(name: 'app_bookings_index', methods: ['GET'])]
    public function index(BookingsRepository $bookingsRepository): Response
    {
		$this->denyAccessUnlessGranted('ROLE_WAITER');

        return $this->render('bookings/index.html.twig', [
            'bookings' => $bookingsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bookings_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, TablesRepository $tablesRepository): Response
    {
        $booking = new Bookings();
        $form = $this->createForm(BookingsType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			$booking->setUser($this->getUser());

			$table = $tablesRepository->findAvailable();
			if(is_null($table)) $this->redirectToRoute('homepage');

			$booking->setTables($table);
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('app_bookings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bookings/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bookings_show', methods: ['GET'])]
    public function show(Bookings $booking): Response
    {
        return $this->render('bookings/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bookings_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bookings $booking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookingsType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bookings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bookings/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bookings_delete', methods: ['POST'])]
    public function delete(Request $request, Bookings $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bookings_index', [], Response::HTTP_SEE_OTHER);
    }
}
