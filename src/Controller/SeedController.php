<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SeedController extends AbstractController
{
    /**
     * @Route("/seed", name="seed")
     */
    public function index(UserRepository $userRepository, ValidatorInterface $validator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $userRepository->findOneBy(['email' => 'a@a.de']);
        if (!$user) {
            $user = new User();
            $user->setEmail('a@a.de');
            $user->setPasswordDigest('test');

            $errors = $validator->validate($user);
            if (count($errors) == 0) {
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }

        return $this->json('ok');
    }
}
