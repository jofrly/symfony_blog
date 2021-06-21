<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SeedController extends AbstractController
{
    /**
     * @Route("/seed", name="seed")
     */
    public function index(ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setEmail('a@a.de');
        $user->setPasswordDigest('test');

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json('ok');
    }
}
