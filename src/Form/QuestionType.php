<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\AnswerType;


class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('active')
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
                ]])
            ->add('answers', CollectionType::class, [
                'entry_type' => AnswerType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
