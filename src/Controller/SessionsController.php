<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class SessionsController extends AbstractController
{
    /**
     * @Route("/login", name="new_session", methods={"GET"})
     */
    public function new(Request $request): Response
    {
        $authenticated = boolval($request->cookies->get('user_id'));
        return $this->render('sessions/new.html.twig', ['authenticated' => $authenticated]);
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
            $cookie = new Cookie('user_id', $user->getId()); // cookie needs encryption otherwise user can set it; just for demo

            $response = new Response('Valid E-Mail or Password!', Response::HTTP_OK);
            $response->headers->setCookie($cookie);
            return $response;
        }

        $this->addFlash('alert', 'Ungültige E-Mail oder Passwort.');
        $authenticated = boolval($request->cookies->get('user_id'));
        return $this->render('sessions/new.html.twig', ['authenticated' => $authenticated], new Response('', 400));
    }
}
