<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Repository\UserRepository;
use App\Repository\TicketRepository;
use App\Entity\Ticket;

#[Route('/avis')]
class AvisController extends AbstractController
{
    private $id_resto;
    private $id_user;
    private $userRepository;
    private $restoRepository;
    private $role_user;

    public function __construct(userRepository $userRepository, Security $security)
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
    }
    #[Route('/', name: 'app_avis_index', methods: ['GET'])]
    public function index(AvisRepository $avisRepository, TicketRepository $ticketRepository): Response
    {
        $tickets = $ticketRepository->findBy(['id_users' => $this->id_user]);

        $ticketvalide = 0;
        foreach ($tickets as $ticket) {
            $verif = $ticket->getPayement();
            if ($verif === 'oui') {
                $ticketvalide++;
            }
        }

        return $this->render('avis/index.html.twig', [
            'avis' => $avisRepository->findBy([], ['id' => 'DESC']),
            'ticket' => $ticketvalide,
        ]);
    }

    #[Route('/new', name: 'app_avis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, TicketRepository $ticketRepository): Response
    {
        $tickets_one = $ticketRepository->findOneBy(['id_users' => $this->id_user], ['id' => 'DESC']);
        $tickets_one_id = $tickets_one->getId();

        $avi = new Avis();
        $avi->setIdTicket($tickets_one_id);

        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avi);
            $entityManager->flush();

            return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('avis/new.html.twig', [
            'avi' => $avi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avis_show', methods: ['GET'])]
    public function show(Avis $avi): Response
    {
        return $this->render('avis/show.html.twig', [
            'avi' => $avi,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_avis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avis $avi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('avis/edit.html.twig', [
            'avi' => $avi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avis_delete', methods: ['POST'])]
    public function delete(Request $request, Avis $avi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $avi->getId(), $request->request->get('_token'))) {
            $entityManager->remove($avi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
    }
}
