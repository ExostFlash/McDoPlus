<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\Ticket2Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use App\Repository\RestoRepository;
use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $id_resto;
    private $id_user;
    private $userRepository;
    private $restoRepository;
    private $menuRepository;
    private $role_user;
    public function __construct(userRepository $userRepository, restoRepository $restoRepository, menuRepository $menuRepository, Security $security)
    {
        $utilisateur = $security->getUser();
        $email_user = $utilisateur->getUserIdentifier();

        $user = $userRepository->findOneBy(['email' => $email_user]);

        $role_user = $user->getGrade();
        $id_resto = $user->getIdResto();
        $id_user = $user->getId();

        $this->role_user = $role_user;
        $this->id_resto = $id_resto;
        $this->id_user = $id_user;
        $this->userRepository = $userRepository;
        $this->restoRepository = $restoRepository;
        $this->menuRepository = $menuRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $resto = $this->restoRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'Home',
            'restos' => $resto,
        ]);
    }

    #[Route('/{idresto}', name: 'app_home_choice')]
    public function choice($idresto): Response
    {
        $resto = $this->restoRepository->find($idresto);
        $menus = $this->menuRepository->findBy(['id_resto' => $idresto]);

        return $this->render('home/choice.html.twig', [
            'controller_name' => 'Home',
            'resto' => $resto,
            'menus' => $menus,
        ]);
    }

    #[Route('/{idresto}/resa', name: 'app_home_resa')]
    public function resa(): Response
    {
        return $this->render('home/resa.html.twig', [
            'controller_name' => 'Home',
        ]);
    }

    #[Route('/{idresto}/{idmenu}', name: 'app_home_ticket')]
    public function ticket($idresto, $idmenu, Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $ticket->setIdResto($idresto);
        $ticket->setIdUsers($this->id_user);
        $ticket->setIdMenu($idmenu);
        $ticket->setPayement('non');

        $form = $this->createForm(Ticket2Type::class, $ticket);

        $form->handleRequest($request);

        $entityManager->persist($ticket);
        $entityManager->flush();

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
