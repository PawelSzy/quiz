<?php

namespace App\Quiz;

class Quiz
{
    private $questions;
    private $numberOfQuestions;
    private $userAnswers;
    private $actualQuestion;
    private $isEnded;

    function __construct(array $questions)
    {
        $this->questions = $questions;
        $this->numberOfQuestions = count($this->questions);
    }

    public function getNumberOfQuestions(): int
    {
        return $this->numberOfQuestions;
    }

}