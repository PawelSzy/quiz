<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('active')
//            ->add('created')
            ->add('questionLevel', ChoiceType::class, [
                'choices'  => [
                    'początkujący' => 1,
                    'zaawansowany' => 2,
                    'expert' => 3,
                ]])
            ->add('sigleOrMulti', ChoiceType::class, [
                'choices'  => [
                    'single' => 0,
                    'multi' => 1,
                ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
