<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Answer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *     fields={"content"},
 *     message="To pytanie już istnieje"
 * )
 */
class Question implements \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="smallint")
     */
    private $questionLevel;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sigleOrMulti;

    /**
     * @ORM\OneToMany(
     *  targetEntity="App\Entity\Answer",
     *  mappedBy="question",
     *  orphanRemoval=true,
     *  cascade={"persist"},
     * )
     * @ORM\JoinTable(
     *  name="answers",
     *  joinColumns={@ORM\JoinColumn(name="answer_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="answer_id", referencedColumnName="id")}
     * )
     */
    private $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getQuestionLevel(): ?int
    {
        return $this->questionLevel;
    }

    public function setQuestionLevel(int $questionLevel): self
    {
        $this->questionLevel = $questionLevel;

        return $this;
    }

    public function getSigleOrMulti(): ?bool
    {
        return $this->sigleOrMulti;
    }

    public function setSigleOrMulti(bool $sigleOrMulti): self
    {
        $this->sigleOrMulti = $sigleOrMulti;

        return $this;
    }

    /**
     * @return Collection|answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    public function checkIfAnswersAreCorrect(array $answers) {
        foreach ($answers as $answer) {
            if (!$answer->getCorrect()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        if ($this->getCreated() === null) {
            $this->setCreated(new \DateTime('now'));
        }
    }

    public function __toString() {
        return $this->getContent();
    }

    public function serialize()
    {
        $answers = serialize($this->answers);
        return json_encode(
            [
                $this->id,
                $this->content,
                $this->questionLevel,
                $this->active,
                $this->created,
                $this->sigleOrMulti,
                $answers,
            ]
        );
    }

    public function unserialize($serialized)
    {
        $data = json_decode($serialized);
        $data[6] = unserialize($data[6]);
        list(
                $this->id,
                $this->content,
                $this->questionLevel,
                $this->active,
                $this->created,
                $this->sigleOrMulti,
                $this->answers,
            ) = $data;
    }

}
