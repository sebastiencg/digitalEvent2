<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Question;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class QuestionFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question')
            ->add('category', EntityType::class,[
                'class'=>Category::class,
                'choice_label'=>'name'
            ])
            ->add('type', EntityType::class,[
                'class'=>Type::class,
                'choice_label'=>'name'
            ])
            ->add('fileName')
            ->add('point', IntegerType::class, [
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'max' => 2,
                        'minMessage' => 'Le niveau doit être au moins {{ limit }}.',
                        'maxMessage' => 'Le niveau ne peut pas dépasser {{ limit }}.',
                    ]),
                ],
            ]);        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
