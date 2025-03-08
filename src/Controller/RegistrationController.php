<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\PersonnelSoignant;
use App\Form\PatientRegistrationFormType;
use App\Form\PersonnelSoignantRegistrationFormType;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(): Response
    {
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }

    #[Route('/register/patient', name: 'app_register_patient')]
    public function registerPatient(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, EmailService $emailService): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientRegistrationFormType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patient->setPassword(
                $userPasswordHasher->hashPassword(
                    $patient,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($patient);
            $entityManager->flush();

            $emailService->sendConfirmationEmail(
                $patient->getEmail(),
                'Confirmation d\'inscription',
                $this->renderView('registration/confirmation_patient_email.html.twig', ['patient' => $patient])
            );

            $this->addFlash('success', 'Patient enregistré avec succès. Un email de confirmation a été envoyé.');

            return $this->redirectToRoute('app_patient_profile', ['id' => $patient->getId()]); // Redirection vers le profil
        }

        return $this->render('registration/register_patient.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/register/personnel', name: 'app_register_personnel')]
    public function registerPersonnelSoignant(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, EmailService $emailService): Response
    {
        $personnelSoignant = new PersonnelSoignant();
        $form = $this->createForm(PersonnelSoignantRegistrationFormType::class, $personnelSoignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personnelSoignant->setPassword(
                $userPasswordHasher->hashPassword(
                    $personnelSoignant,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($personnelSoignant);
            $entityManager->flush();

            $emailService->sendConfirmationEmail(
                $personnelSoignant->getEmail(),
                'Confirmation d\'inscription',
                $this->renderView('registration/confirmation_personnel_email.html.twig', ['personnelSoignant' => $personnelSoignant])
            );

            $this->addFlash('success', 'Personnel soignant enregistré avec succès. Un email de confirmation a été envoyé.');

            return $this->redirectToRoute('app_personnel_profile', ['id' => $personnelSoignant->getId()]); // Redirection vers le profil
        }

        return $this->render('registration/register_personnel.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/patient/profile/{id}', name: 'app_patient_profile')]
    #[IsGranted('ROLE_USER')]
    public function patientProfile(Patient $patient): Response
    {
        return $this->render('registration/patient_profile.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/personnel/profile/{id}', name: 'app_personnel_profile')]
    #[IsGranted('ROLE_USER')]
    public function personnelProfile(PersonnelSoignant $personnelSoignant): Response
    {
        return $this->render('registration/personnel_profile.html.twig', [
            'personnelSoignant' => $personnelSoignant,
        ]);
    }
}
