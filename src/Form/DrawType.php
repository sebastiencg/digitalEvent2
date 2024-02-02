<?php

namespace App\Form;

use App\Entity\Draw;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DrawType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', EntityType::class, [
                'class' => Question::class,
                'choice_label' => 'question', // Remplacez 'questionText' par le nom du champ représentant le texte de la question dans votre entité Question
                'multiple' => true,
                'expanded' => true, // Si vous souhaitez afficher les questions sous forme de cases à cocher
                'by_reference' => false,
                'attr' => [
                    'class' => 'question-collection',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Draw::class,
        ]);
    }
}
