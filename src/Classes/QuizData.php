<?php

namespace App\Classes;

use Symfony\Component\Validator\Constraints as Assert;

class QuizData
{
    /**
     * @Assert\NotBlank
     * @Assert\GreaterThan(0)
     */
    public $numberOfQuestions;

    /**
     * @Assert\NotBlank
     * @Assert\GreaterThan(0)
     */
    public $levelOfQuestion;
}