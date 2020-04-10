<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
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
     * @var string
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(mode="html5")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 8,
     *      max = 255,
     *      minMessage = "Votre mot de passe doit contenir minimum {{ limit }} caractères",
     *      maxMessage = "Votre mot de passe ne doit pas dépasser {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Votre pseudonyme doit contenir minimum {{ limit }} caractères",
     *      maxMessage = "Votre pseudonyme ne doit pas dépasser {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $pseudo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Agenda", mappedBy="user", cascade={"persist", "remove"})
     */
    private $agenda;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AgendaComment", mappedBy="user", cascade={"persist", "remove"})
     */
    private $agendaComments;

    public function __construct()
    {
        $this->agenda = new ArrayCollection();
        $this->agendaComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return Collection|Agenda[]
     */
    public function getAgenda(): Collection
    {
        return $this->agenda;
    }

    public function addAgenda(Agenda $agenda): self
    {
        if (!$this->agenda->contains($agenda)) {
            $this->agenda[] = $agenda;
            $agenda->setUser($this);
        }

        return $this;
    }

    public function removeAgenda(Agenda $agenda): self
    {
        if ($this->agenda->contains($agenda)) {
            $this->agenda->removeElement($agenda);
            // set the owning side to null (unless already changed)
            if ($agenda->getUser() === $this) {
                $agenda->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AgendaComment[]
     */
    public function getAgendaComments(): Collection
    {
        return $this->agendaComments;
    }

    public function addAgendaComment(AgendaComment $agendaComment): self
    {
        if (!$this->agendaComments->contains($agendaComment)) {
            $this->agendaComments[] = $agendaComment;
            $agendaComment->setUser($this);
        }

        return $this;
    }

    public function removeAgendaComment(AgendaComment $agendaComment): self
    {
        if ($this->agendaComments->contains($agendaComment)) {
            $this->agendaComments->removeElement($agendaComment);
            // set the owning side to null (unless already changed)
            if ($agendaComment->getUser() === $this) {
                $agendaComment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->pseudo;
    }
}
