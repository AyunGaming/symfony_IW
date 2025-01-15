<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Model\MailMessage as ModelMailMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $event = new ModelMailMessage();
        $form = $this->createForm(ContactFormType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $email = (new Email())
                    ->from($event->getSender())
                    ->to("allan6901390@gmail.com")
                    ->subject($event->getObject())
                    ->text($event->getMessage());

                $mailer->send($email);

                $this->addFlash('success', 'Your email was sent successfully!');
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred while sending your email: ' . $e->getMessage());
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
