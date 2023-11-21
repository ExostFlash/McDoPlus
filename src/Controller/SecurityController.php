<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/user/login', name: 'app_user_login', methods: ['GET', 'POST'])]
    public function login(): Response
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    #[Route('/user/logout', name: 'app_user_logout')]
    public function logout(): Response
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
}
