<?php

namespace App\Quiz;

use App\Entity\Question;

class Quiz implements \Serializable, \Iterator
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
        if ($this->getNumberOfQuestions() > 0 ) {
            $this->actualQuestion = 0;
        }
    }

    public function getNumberOfQuestions(): int
    {
        return $this->numberOfQuestions;
    }

    public function addUserAnswer(int $questionId, int $answerId)
    {
        $this->userAnswers[$questionId] = $answerId;
    }

    public function getUserAnswer(int $questionId): mixed
    {
        if (isset($this->userAnswers[$questionId])) {
            return $this->userAnswers[$questionId];
        }

        return false;
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