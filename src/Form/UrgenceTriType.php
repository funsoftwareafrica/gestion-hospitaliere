<?php

namespace App\Form;

use App\Entity\Urgence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UrgenceTriType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('symptomes', TextareaType::class, [
                'label' => 'Symptômes',
                'required' => false,
            ])
            ->add('scoreSymptomes', NumberType::class, [
                'label' => 'Score des symptômes',
                'required' => false,
            ])
            ->add('antecedents', TextareaType::class, [
                'label' => 'Antécédents médicaux',
                'required' => false,
            ])
            ->add('scoreAntecedents', NumberType::class, [
                'label' => 'Score des antécédents',
                'required' => false,
            ])
            ->add('signesVitaux', TextareaType::class, [
                'label' => 'Signes vitaux',
                'required' => false,
            ])
            ->add('scoreSignesVitaux', NumberType::class, [
                'label' => 'Score des signes vitaux',
                'required' => false,
            ])
            ->add('niveauGravite', ChoiceType::class, [
                'label' => 'Niveau de gravité',
                'choices' => [
                    'Urgence vitale' => 1,
                    'Urgence majeure' => 2,
                    'Urgence mineure' => 3,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Urgence::class,
        ]);
    }
}
