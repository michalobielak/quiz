<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('answer', ChoiceType::class, [
                'choices'  => [
                    'Zdecydowanie nie' => 1,
                    'Raczej nie' => 2,
                    'i tak i nie' => 3,
                    'Raczej tak' => 4,
                    'Zdecydowanie tak' => 5,

                ],
                'expanded' =>true,
                'data' => 1,
                'label' => ' ',
                'choice_attr' => function($choice, $key, $value){
                    return ['class' => 'form-check-input'];
                }
            ])
            ->add('question_id', HiddenType::class, ['mapped' => false])
            ->add('Odpowiedz', ButtonType::class, ['attr' => ['class' => 'btn-primary']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
