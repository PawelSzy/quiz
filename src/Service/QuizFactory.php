<?php

namespace App\Service;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class QuizFactory
{

    private $questionRepository;

    function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function createQuiz(int $questionsLevel, int $numberOfQuestions)
    {
        if($questionsLevel <= 0 || $numberOfQuestions <= 0) {
            throw new Exception('Question level and number of question should be greater than 0.');
        }

        $questions = $this->questionRepository->findByLevel($questionsLevel);
        if (count($questions) > $numberOfQuestions) {
            $questions = array_rand($questions, $numberOfQuestions);
        }

        return $questions;
    }
}