<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgendaRepository")
 * @Vich\Uploadable
 */
class Agenda
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="titre")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateHeure;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string|null
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="event_image", fileNameProperty="image")
     * @Assert\Image(mimeTypes="image/jpeg")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AgendaComment", mappedBy="agenda", cascade={"persist", "remove"})
     */
    private $agendaComments;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct()
    {
        $this->agendaComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateHeure(): ?\DateTimeInterface
    {
        return $this->dateHeure;
    }

    public function setDateHeure(\DateTimeInterface $dateHeure): self
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): Agenda
    {
        $this->updatedAt = $updatedAt;

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
            $agendaComment->setAgenda($this);
        }

        return $this;
    }

    public function removeAgendaComment(AgendaComment $agendaComment): self
    {
        if ($this->agendaComments->contains($agendaComment)) {
            $this->agendaComments->removeElement($agendaComment);
            // set the owning side to null (unless already changed)
            if ($agendaComment->getAgenda() === $this) {
                $agendaComment->setAgenda(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->titre;
    }
}
