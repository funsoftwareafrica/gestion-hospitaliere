<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PatientController extends AbstractController
{
    #[Route('/formpatient/', name: 'patient_index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $patients = $doctrine->getRepository(Patient::class)->findAll();

        return $this->render('patient/index.html.twig', [
            'patients' => $patients,
        ]);
    }

    #[Route('/patient/new', name: 'patient_new')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();

            $this->addFlash('success', 'Le patient a été enregistré avec succès.');

            return $this->redirectToRoute('patient_index');
        }

        return $this->render('patient/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/patient/{id}', name: 'patient_show', methods: ['GET'])]
    public function show(Patient $patient): Response
    {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/patient/{id}/edit', name: 'patient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patient $patient, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();

            $this->addFlash('success', 'Le patient a été modifié avec succès.');

            return $this->redirectToRoute('patient_index');
        }

        return $this->render('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/patient/delete/{id}', name: 'patient_delete', methods: ['POST'])]
    public function delete(Patient $patient, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($patient);
        $entityManager->flush();

        $this->addFlash('success', 'Patient supprimé avec succès.');

        return $this->redirectToRoute('patient_index');
    }
}
