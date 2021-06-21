<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SeedController extends AbstractController
{
    /**
     * @Route("/seed", name="seed")
     */
    public function index(UserRepository $userRepository, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $userEmail = 'a@a.de';
        $userPassword = 'string123';
        $user = $userRepository->findOneBy(['email' => $userEmail]);
        if (!$user) {
            $user = new User();
            $hashedPassword = $passwordHasher->hashPassword($user, $userPassword);
            $user->setEmail($userEmail);
            $user->setPassword($hashedPassword);

            $errors = $validator->validate($user);
            if (count($errors) == 0) {
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }

        return $this->json('ok');
    }
}
