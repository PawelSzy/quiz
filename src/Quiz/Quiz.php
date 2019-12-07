<?php

namespace App\Quiz;

class Quiz implements \Serializable
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