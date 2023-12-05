<?php

// src/Controller/ErrorController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/error', name: 'access_error')]
class ErrorController extends AbstractController
{
    #[Route('/403', name: 'access_denied')]

    public function accessDenied(): Response
    {
        return $this->render('error/access_denied.html.twig', []);
    }
}
