<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nb_max_pers = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_create = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $poster = null;

    #[ORM\ManyToMany(targetEntity: Multimedia::class, inversedBy: 'events')]
    private Collection $multimedias;

    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Participate::class, mappedBy: 'events')]
    private Collection $participates;

    public function __construct()
    {
        $this->multimedias = new ArrayCollection();
        $this->participates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbMaxPers(): ?int
    {
        return $this->nb_max_pers;
    }

    public function setNbMaxPers(int $nb_max_pers): self
    {
        $this->nb_max_pers = $nb_max_pers;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeInterface $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * @return Collection<int, Multimedia>
     */
    public function getMultimedias(): Collection
    {
        return $this->multimedias;
    }

    public function addMultimedia(Multimedia $multimedia): self
    {
        if (!$this->multimedias->contains($multimedia)) {
            $this->multimedias->add($multimedia);
        }

        return $this;
    }

    public function removeMultimedia(Multimedia $multimedia): self
    {
        $this->multimedias->removeElement($multimedia);

        return $this;
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

    /**
     * @return Collection<int, Participate>
     */
    public function getParticipates(): Collection
    {
        return $this->participates;
    }

    public function addParticipate(Participate $participate): self
    {
        if (!$this->participates->contains($participate)) {
            $this->participates->add($participate);
            $participate->addEvent($this);
        }

        return $this;
    }

    public function removeParticipate(Participate $participate): self
    {
        if ($this->participates->removeElement($participate)) {
            $participate->removeEvent($this);
        }

        return $this;
    }
}
