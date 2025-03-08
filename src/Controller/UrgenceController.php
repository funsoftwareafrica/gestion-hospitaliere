<?php

namespace App\Controller;

use App\Entity\Urgence;
use App\Repository\UrgenceRepository; // Importez le UrgenceRepository
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\UrgenceType;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/urgence')]
final class UrgenceController extends AbstractController
{
    #[Route('/', name: 'urgence_index', methods: ['GET'])]
    public function index(UrgenceRepository $urgenceRepository): Response
    {
        // Utilisation de la méthode de tri findByPriorityAsc()
        $urgences = $urgenceRepository->findByPriorityAsc();

        // Vous pouvez utiliser d'autres méthodes de tri selon vos besoins
        // $urgences = $urgenceRepository->findByCreatedAtDesc();
        // $urgences = $urgenceRepository->findByPriorityAndCreatedAtAsc();

        return $this->render('urgence/index.html.twig', [
            'urgences' => $urgences,
        ]);
    }

    // ... autres méthodes (new, show, edit, delete) restent inchangées ...

    #[Route('/new', name: 'urgence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $urgence = new Urgence();
        $form = $this->createForm(UrgenceType::class, $urgence);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($urgence);
            $entityManager->flush();

            return $this->redirectToRoute('urgence_index');
        }

        return $this->render('urgence/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'urgence_show', methods: ['GET'])]
    public function show(Urgence $urgence): Response
    {
        return $this->render('urgence/show.html.twig', [
            'urgence' => $urgence,
        ]);
    }

    #[Route('/{id}/edit', name: 'urgence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Urgence $urgence, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(UrgenceType::class, $urgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();

            return $this->redirectToRoute('urgence_index');
        }

        return $this->render('urgence/edit.html.twig', [
            'urgence' => $urgence,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'urgence_delete', methods: ['POST'])]
    public function delete(Request $request, Urgence $urgence, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete' . $urgence->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($urgence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('urgence_index');
    }
}
