<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numberOfQuestions', IntegerType::class, [
                'label' => 'Liczba pytań',
            ])
            ->add('levelOfQuestion', ChoiceType::class, [
                'choices'  => [
                    'początkujący' => 1,
                    'zaawansowany' => 2,
                    'expert' => 3,
                ]])
            ->add('save', SubmitType::class, [
                'label' => 'Zacznij Quiz',
                'attr' => ['class' => 'save'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
