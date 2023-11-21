<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserSignupType;
use App\Form\UserLoginType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/signup', name: 'app_user_signup')]
    public function signup(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user_entity = new User(); // Remplacez par votre entité User
        $form = $this->createForm(UserSignupType::class, $user_entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération du mot de passe en clair depuis le formulaire
            $plainPassword = $form->get('mdp')->getData();

            // Encodage sécurisé du mot de passe
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

            // Définition du mot de passe haché sur l'entité User
            $user_entity->setMdp($hashedPassword);

            // Enregistrement de l'utilisateur
            $entityManager->persist($user_entity);
            $entityManager->flush();

            // Redirection après l'enregistrement
            return $this->redirectToRoute('app_user_login');
        }

        return $this->render('user/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/login', name: 'app_user_login')]
    public function login(): Response
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
