<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswerRepository")
 */
class Answer implements \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $correct;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $answer_order;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="answers")
     * @ORM\JoinColumn(nullable=false, name="question_id", referencedColumnName="id")
     */
    private $question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCorrect(): ?bool
    {
        return $this->correct;
    }

    public function setCorrect(bool $correct): self
    {
        $this->correct = $correct;

        return $this;
    }

    public function getAnswerOrder(): ?int
    {
        return $this->answer_order;
    }

    public function setAnswerOrder(int $answer_order): self
    {
        $this->answer_order = $answer_order;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function __toString() {
       return $this->getContent();
    }

    public function serialize()
    {

       return json_encode(
        [
            $this->id,
            $this->content,
            $this->correct,
            $this->answer_order,
        ]
      );
    }

    public function unserialize($serialized)
    {
        $data = json_decode($serialized);
        list(
            $this->id,
            $this->content,
            $this->correct,
            $this->answer_order,
        ) = $data;
    }

}
