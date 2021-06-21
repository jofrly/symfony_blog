<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class SessionsController extends AbstractController
{
    /**
     * @Route("/login", name="new_session", methods={"GET"})
     */
    public function new(): Response
    {
        return $this->render('sessions/new.html.twig', []);
    }

    /**
     * @Route("/login", name="create_session", methods={"POST"})
     */
    public function create(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $user = $userRepository->findOneBy(['email' => $email]);
        if ($user && $passwordHasher->isPasswordValid($user, $password)) {
            return $this->json('Valid E-Mail or Password!');
        }

        $this->addFlash('alert', 'Ungültige E-Mail oder Passwort.');
        return $this->redirectToRoute('new_session');
    }
}
