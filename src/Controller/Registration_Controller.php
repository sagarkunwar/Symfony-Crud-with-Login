<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Registration_Controller extends AbstractController
{

    public function index(UserPasswordHasherInterface $passwordHasher)
    {
        // ... eg get the user data from a registration form
        $user = new User();
        $plaintextPassword = "123";

        // hash the password (based on the security )

        $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPassword);
    }
    /**
     * @Route("/log", name="log")
     */
    public function log(): Response
    {
        return $this->render('main/index.html.twig', []);
    }
}
