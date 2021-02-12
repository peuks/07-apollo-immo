<?php

namespace App\Entity;

use App\Repository\TravaillerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TravaillerRepository::class)
 */
class Travailler
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startedAt;

    /**
     * @ORM\OneToMany(targetEntity=Agence::class, mappedBy="travailler")
     */
    private $agency;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="travaillers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->agency = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * @return Collection|Agence[]
     */
    public function getAgency(): Collection
    {
        return $this->agency;
    }

    public function addAgency(Agence $agency): self
    {
        if (!$this->agency->contains($agency)) {
            $this->agency[] = $agency;
            $agency->setTravailler($this);
        }

        return $this;
    }

    public function removeAgency(Agence $agency): self
    {
        if ($this->agency->removeElement($agency)) {
            // set the owning side to null (unless already changed)
            if ($agency->getTravailler() === $this) {
                $agency->setTravailler(null);
            }
        }

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
}
