<?php

namespace App\Form;

use App\Entity\Urgence;
use App\Entity\Patient;
use App\Entity\PersonnelSoignant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UrgenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => 'nom',
                'label' => 'Patient',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner un patient.']),
                ],
            ])
            ->add('dateArrivee', DateTimeType::class, [
                'label' => 'Date d\'arrivée',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir la date d\'arrivée.']),
                ],
            ])
            ->add('motif', TextareaType::class, [
                'label' => 'Motif',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir le motif.']),
                ],
            ])
            ->add('niveauGravite', ChoiceType::class, [
                'choices' => [
                    'Faible' => 1,
                    'Moyen' => 2,
                    'Élevé' => 3,
                ],
                'label' => 'Niveau de gravité',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner le niveau de gravité.']),
                ],
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'En attente' => 'En attente',
                    'En cours' => 'En cours',
                    'Terminé' => 'Terminé',
                ],
                'label' => 'Statut',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner le statut.']),
                ],
            ])
            ->add('personnelSoignant', EntityType::class, [
                'class' => PersonnelSoignant::class,
                'choice_label' => 'nom',
                'label' => 'Personnel soignant (facultatif)',
                'required' => false,
            ])
            ->add('datePriseEnCharge', DateTimeType::class, [
                'label' => 'Date de prise en charge (facultatif)',
                'required' => false,
            ])
            ->add('dateFin', DateTimeType::class, [
                'label' => 'Date de fin (facultatif)',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Urgence::class,
        ]);
    }
}
