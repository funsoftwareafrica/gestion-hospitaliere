<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir un nom.']),
                    new Length(['max' => 255, 'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.']),
                ],
                'attr' => ['placeholder' => 'Nom', 'autocomplete' => 'family-name'],
            ])
            ->add('prenom', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir un prénom.']),
                    new Length(['max' => 255, 'maxMessage' => 'Le prénom ne peut pas dépasser {{ limit }} caractères.']),
                ],
                'attr' => ['placeholder' => 'Prénom', 'autocomplete' => 'given-name'],
            ])
            ->add('dateNaissance', DateType::class, ['attr' => ['autocomplete' => 'bday']])
            ->add('sexe', ChoiceType::class, [
                'choices' => ['Homme' => 'Homme', 'Femme' => 'Femme', 'Autre' => 'Autre'],
                'placeholder' => 'Sélectionnez un sexe',
                'attr' => ['autocomplete' => 'sex'],
            ])
            ->add('adresse', null, ['attr' => ['placeholder' => 'Adresse', 'autocomplete' => 'street-address']])
            ->add('telephone', TelType::class, [
                'constraints' => [
                    new Regex(['pattern' => '/^[0-9\-\+\s\(\)]+$/', 'message' => 'Veuillez saisir un numéro de téléphone valide.']),
                ],
                'attr' => ['placeholder' => 'Téléphone', 'autocomplete' => 'tel'],
            ])
            ->add('antecedentsMedicaux', null, ['attr' => ['placeholder' => 'Antécédents médicaux']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Patient::class]);
    }
}
