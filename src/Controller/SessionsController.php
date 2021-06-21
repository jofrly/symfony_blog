<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function create(LoggerInterface $logger, Request $request): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        return $this->json(['test' => 'toast']);
    }
}
