<?php

namespace App\Controller;

use App\Entity\Resa;
use App\Form\ResaType;
use App\Repository\ResaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service/resa')]
class ResaServiceController extends AbstractController
{
    #[Route('/', name: 'app_resa_service_index', methods: ['GET'])]
    public function index(ResaRepository $resaRepository): Response
    {
        return $this->render('resa_service/index.html.twig', [
            'resas' => $resaRepository->findAll(),
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
