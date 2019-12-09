<?php

namespace App\Quiz;

use App\Entity\Answer;
use App\Entity\Question;

class Quiz implements \Serializable, \Iterator
{
    private $questions;
    private $numberOfQuestions;
    private $userAnswers = [];
    private $actualQuestion;
    private $isEnded;

    function __construct(array $questions)
    {
        $this->questions = $questions;
        $this->numberOfQuestions = count($this->questions);
        if ($this->getNumberOfQuestions() > 0 ) {
            $this->actualQuestion = 0;
        }
    }

    public function getNumberOfQuestions(): int
    {
        return $this->numberOfQuestions;
    }

    public function addUserAnswer(int $questionId, Answer $answer)
    {
        if (!isset($this->userAnswers[$questionId])) {
            $this->userAnswers[$questionId] = [];
        }

        $this->userAnswers[$questionId][] = $answer;
    }

    public function getUserAnswer(int $questionId): mixed
    {
        if (isset($this->userAnswers[$questionId])) {
            return $this->userAnswers[$questionId];
        }

        return false;
    }

    public function getUserAnswers(): array
    {
        return $this->userAnswers;
    }

    public function isQuizPassed(float $percantageOfPassed = 0.8) {

        $passedQuestion = 0;
        foreach ($this->getUserAnswers() as $questionId => $answers) {
            $isQuestionPassed = true;
            foreach($answers as $answer) {
                if (!$answer->getCorrect()) {
                    $isQuestionPassed = false;
                    break;
                }
            }

            if( $isQuestionPassed) {
                $passedQuestion++;
            }
        }

       return $passedQuestion /  $this->getNumberOfQuestions() >= $percantageOfPassed;

    }

    public function current(): Question
    {
        return $this->questions[$this->actualQuestion];
    }
    public function key() : scalar
    {
        return $this->actualQuestion;
    }

    public function next() : void
    {
        ++$this->actualQuestion;
    }

    public function rewind(): void
    {
        $this->actualQuestion = 0;
    }

    public function valid(): bool
    {
        return isset($this->questions[$this->actualQuestion]);
    }

    public function serialize()
    {
        return serialize(
            [
                $this->questions,
                $this->numberOfQuestions,
                $this->userAnswers,
                $this->actualQuestion,
                $this->isEnded,
            ]
        );
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        list(
            $this->questions,
            $this->numberOfQuestions,
            $this->userAnswers,
            $this->actualQuestion,
            $this->isEnded,
            ) = $data;
    }
}