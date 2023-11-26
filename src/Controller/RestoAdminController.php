<?php

namespace App\Controller;

use App\Entity\Resto;
use App\Form\RestoType;
use App\Repository\RestoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/resto')]
class RestoAdminController extends AbstractController
{
    #[Route('/', name: 'app_resto_admin_index', methods: ['GET'])]
    public function index(RestoRepository $restoRepository): Response
    {
        return $this->render('resto_admin/index.html.twig', [
            'restos' => $restoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_resto_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $resto = new Resto();
        $form = $this->createForm(RestoType::class, $resto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($resto);
            $entityManager->flush();

            return $this->redirectToRoute('app_resto_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('resto_admin/new.html.twig', [
            'resto' => $resto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_resto_admin_show', methods: ['GET'])]
    public function show(Resto $resto): Response
    {
        return $this->render('resto_admin/show.html.twig', [
            'resto' => $resto,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_resto_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Resto $resto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RestoType::class, $resto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_resto_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('resto_admin/edit.html.twig', [
            'resto' => $resto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_resto_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Resto $resto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resto->getId(), $request->request->get('_token'))) {
            $entityManager->remove($resto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_resto_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
