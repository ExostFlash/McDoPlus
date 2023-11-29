<?php

namespace App\Controller;

use App\Entity\Resa;
use App\Form\ResaType;
use Symfony\Component\Security\Core\Security;
use App\Repository\ResaRepository;
use App\Repository\UserRepository;
use App\Repository\RestoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service/resa')]
class ResaServiceController extends AbstractController
{
    private $id_resto;
    private $id_user;
    private $userRepository;
    private $restoRepository;
    private $role_user;

    public function __construct(userRepository $userRepository, restoRepository $restoRepository, Security $security)
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
    }

    #[Route('/', name: 'app_resa_service_index', methods: ['GET'])]
    public function index(ResaRepository $resaRepository): Response
    {
        // Obtenez la date d'aujourd'hui
        $today = new \DateTime('today');

        if ($this->role_user != 'Root') {
            $resasDuJour = $resaRepository->findBy([
                'jour' => $today,
                'id_resto' => $this->id_resto,
            ]);
        } else {
            $resasDuJour = $resaRepository->findBy([
                'jour' => $today,
            ]);
        }

        $users = [];
        foreach ($resasDuJour as $resa) {
            $userId = $resa->getIdUser();
            $user = $this->userRepository->find($userId);
            if ($user !== null) {
                $users[$userId] = $user;
            }
        }

        return $this->render('resa_service/index.html.twig', [
            'resas' => $resasDuJour,
            'j1' => $today->modify('+1 day'),
            'users' => $users,
        ]);
    }

    #[Route('/jour/{datej}', name: 'app_resa_service_jour', methods: ['GET'])]
    public function byjour($datej, ResaRepository $resaRepository): Response
    {
        $today = \DateTime::createFromFormat('Y-m-d', $datej);;

        if ($this->role_user != 'Root') {
            $resasDuJour = $resaRepository->findBy([
                'jour' => $today,
                'id_resto' => $this->id_resto,
            ]);
        } else {
            $resasDuJour = $resaRepository->findBy([
                'jour' => $today,
            ]);
        }

        $users = [];
        foreach ($resasDuJour as $resa) {
            $userId = $resa->getIdUser();
            $user = $this->userRepository->find($userId);
            if ($user !== null) {
                $users[$userId] = $user;
            }
        }

        return $this->render('resa_service/index.html.twig', [
            'resas' => $resasDuJour,
            'j1' => $today->modify('+1 day'),
            'users' => $users,
        ]);
    }

    #[Route('/new', name: 'app_resa_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $id_user = $this->id_user;

        $resa = new Resa();
        $resa->setIdUser($id_user);

        $form = $this->createForm(ResaType::class, $resa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($resa);
            $entityManager->flush();

            return $this->redirectToRoute('app_resa_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('resa_service/new.html.twig', [
            'resa' => $resa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_resa_service_show', methods: ['GET'])]
    public function show(Resa $resa): Response
    {
        return $this->render('resa_service/show.html.twig', [
            'resa' => $resa,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_resa_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Resa $resa, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResaType::class, $resa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_resa_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('resa_service/edit.html.twig', [
            'resa' => $resa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_resa_service_delete', methods: ['POST'])]
    public function delete(Request $request, Resa $resa, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $resa->getId(), $request->request->get('_token'))) {
            $entityManager->remove($resa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_resa_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
