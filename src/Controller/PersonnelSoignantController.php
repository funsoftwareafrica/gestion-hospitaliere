<?php

namespace App\Controller;

use App\Entity\PersonnelSoignant;
use App\Form\PersonnelSoignantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonnelSoignantController extends AbstractController
{
    #[Route('/personnel-soignant/', name: 'personnel_soignant_index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $personnelSoignants = $doctrine->getRepository(PersonnelSoignant::class)->findAll();

        return $this->render('personnel_soignant/index.html.twig', [
            'personnelSoignants' => $personnelSoignants,
        ]);
    }

    #[Route('/personnel-soignant/new', name: 'personnel_soignant_new')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $personnelSoignant = new PersonnelSoignant();
        $form = $this->createForm(PersonnelSoignantType::class, $personnelSoignant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($personnelSoignant);
            $entityManager->flush();

            return $this->redirectToRoute('personnel_soignant_index');
        }

        return $this->render('personnel_soignant/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
