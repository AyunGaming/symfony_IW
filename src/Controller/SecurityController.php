<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
		// get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(Security $security, EventRepository $eventRepository)
    {
    	$response = $security->logout();

		// you can also disable the csrf logout
		$response = $security->logout(false);

		$this->render('landing_page/index.html.twig', [
			'firstEvent' => $eventRepository->findOneBy([], ['date' => 'ASC'])
		]);
		return $this->redirectToRoute('homepage');
    }
    
}
