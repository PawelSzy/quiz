<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="boolean")
     */
    private $quizFinished;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserDetails", mappedBy="user", cascade={"persist", "remove"})
     */
    private $userDetails;

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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

    public function getQuizFinished(): ?bool
    {
        return $this->quizFinished;
    }

    public function setQuizFinished(bool $quizFinished): self
    {
        $this->quizFinished = $quizFinished;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        // not needed for apps that do not check user passwords
    }

        /**
         * @see UserInterface
         */
        public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }
    
        /**
         * @see UserInterface
         */
        public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserDetails(): ?UserDetails
    {
        return $this->userDetails;
    }

    public function setUserDetails(?UserDetails $userDetails): self
    {
        $this->userDetails = $userDetails;

        // set (or unset) the owning side of the relation if necessary
        $newUser = null === $userDetails ? null : $this;
        if ($userDetails->getUser() !== $newUser) {
            $userDetails->setUser($newUser);
        }

        return $this;
    }

}
