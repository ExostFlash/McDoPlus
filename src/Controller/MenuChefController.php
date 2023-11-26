<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use App\Repository\UserRepository;
use App\Repository\RestoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/chef/menu')]
class MenuChefController extends AbstractController
{

    private $id_resto;
    private $id_user;
    private $userRepository;
    private $restoRepository;

    public function __construct(userRepository $userRepository, restoRepository $restoRepository, Security $security)
    {
        $utilisateur = $security->getUser();
        $email_user = $utilisateur->getUserIdentifier();

        $user = $userRepository->findOneBy(['email' => $email_user]);

        $id_resto = $user->getIdResto();
        $id_user = $user->getId();
        $this->id_resto = $id_resto;
        $this->id_user = $id_user;
        $this->userRepository = $userRepository;
        $this->restoRepository = $restoRepository;
    }
    #[Route('/', name: 'app_menu_chef_index', methods: ['GET'])]
    public function index(MenuRepository $menuRepository): Response
    {
        if ($this->id_resto != '') {
            $menus = $menuRepository->findBy(['id_resto' => $this->id_resto]);
        } else {
            $this->id_resto = 0;
            $menus = $menuRepository->findAll();
        }

        $users = [];
        foreach ($menus as $menu) {
            $userId = $menu->getIdUsers();
            $user = $this->userRepository->find($userId);
            if ($user !== null) {
                $users[$userId] = $user;
            }
        }

        $restos = [];
        foreach ($menus as $menu) {
            $restoId = $menu->getIdResto();
            $resto = $this->restoRepository->find($restoId);
            if ($resto !== null) {
                $restos[$restoId] = $resto;
            }
        }

        return $this->render('menu_chef/index.html.twig', [
            'menus' => $menus,
            'users' => $users,
            'restos' => $restos,
            'id_resto' => $this->id_resto,
        ]);
    }

    #[Route('/new', name: 'app_menu_chef_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $id_resto = $this->id_resto;
        $id_user = $this->id_user;

        $menu = new Menu();
        $menu->setIdResto($id_resto);
        $menu->setIdUsers($id_user);

        $form = $this->createForm(MenuType::class, $menu);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($menu);
            $entityManager->flush();

            return $this->redirectToRoute('app_menu_chef_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('menu_chef/new.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_menu_chef_show', methods: ['GET'])]
    public function show(Menu $menu): Response
    {
        return $this->render('menu_chef/show.html.twig', [
            'menu' => $menu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_menu_chef_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_menu_chef_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('menu_chef/edit.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_menu_chef_delete', methods: ['POST'])]
    public function delete(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $menu->getId(), $request->request->get('_token'))) {
            $entityManager->remove($menu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_menu_chef_index', [], Response::HTTP_SEE_OTHER);
    }
}
