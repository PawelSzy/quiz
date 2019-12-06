<?php

namespace App\Service;

use App\Entity\Question;
use App\Quiz\Quiz;
use App\Repository\QuestionRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class QuizFactory
{

    private $questionRepository;

    function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function createQuiz(int $questionsLevel, int $numberOfQuestions): Quiz
    {
        if($questionsLevel <= 0 || $numberOfQuestions <= 0) {
            throw new Exception('Question level and number of question should be greater than 0.');
        }

        $questions = $this->questionRepository->findByLevel($questionsLevel);
        dump($questions);
        if (count($questions) > $numberOfQuestions) {
            array_rand($questions, $numberOfQuestions);
            dump($questions);
            dump($number)
            $questions = array_slice($questions, 0, $numberOfQuestions);
            dump($questions);
        }

        $quiz = new Quiz($questions);

        return $quiz;
    }
}