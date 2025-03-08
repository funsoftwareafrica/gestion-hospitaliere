<?php

namespace App\Form;

use App\Entity\PersonnelSoignant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PersonnelSoignantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('specialite', ChoiceType::class, [
                'choices' => [
                    'Médecin' => 'Médecin',
                    'Infirmier' => 'Infirmier',
                    'Aide-soignant' => 'Aide-soignant',
                ],
                'placeholder' => 'Sélectionnez une spécialité',
            ])
            ->add('telephone')
            ->add('email')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PersonnelSoignant::class,
        ]);
    }
}
