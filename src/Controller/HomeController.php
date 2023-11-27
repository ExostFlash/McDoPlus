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
    public function __construct(UserRepository $userRepository, RestoRepository $restoRepository, MenuRepository $menuRepository, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->restoRepository = $restoRepository;
        $this->menuRepository = $menuRepository;

        $utilisateur = $security->getUser();

        if ($utilisateur != null) {
            $email_user = $utilisateur->getUserIdentifier();
            $user = $userRepository->findOneBy(['email' => $email_user]);

            if ($user) {
                $role_user = $user->getGrade();
                $id_resto = $user->getIdResto();
                $id_user = $user->getId();

                $this->role_user = $role_user;
                $this->id_resto = $id_resto;
                $this->id_user = $id_user;
            }
        }
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

    #[Route('/choix/{idresto}', name: 'app_home_choice')]
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

    #[Route('/resa/{idresto}', name: 'app_home_resa')]
    public function resa(): Response
    {
        return $this->render('home/resa.html.twig', [
            'controller_name' => 'Home',
        ]);
    }

    #[Route('/ticket/{idresto}/{idmenu}', name: 'app_home_ticket')]
    public function ticket($idresto, $idmenu, Request $request, EntityManagerInterface $entityManager): Response
    {
        $idresto = (int) $idresto;
        $idmenu = (int) $idmenu;

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

    #[Route('/menu/{idresto}', name: 'app_home_menu')]
    public function menu($idresto): Response
    {
        $resto = $this->restoRepository->find($idresto);
        $menus = $this->menuRepository->findBy(['id_resto' => $idresto]);

        return $this->render('home/menu.html.twig', [
            'controller_name' => 'Home',
            'resto' => $resto,
            'menus' => $menus,
        ]);
    }
}
