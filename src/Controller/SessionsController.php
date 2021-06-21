<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionsController extends AbstractController
{
    /**
     * @Route("/login", name="new_session")
     */
    public function new(): Response
    {
        return $this->render('sessions/new.html.twig', []);
    }
}
