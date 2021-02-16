<?php

namespace App\Entity;

use App\Repository\CandidaterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidaterRepository::class)
 */
class Candidater
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
    private $candidature_at;

    /**
     * @ORM\Column(type="dateinterval")
     */
    private $souhait_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Property::class, inversedBy="candidatures")
     */
    private $property;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidatureAt(): ?\DateTimeInterface
    {
        return $this->candidature_at;
    }

    public function setCandidatureAt(\DateTimeInterface $candidature_at): self
    {
        $this->candidature_at = $candidature_at;

        return $this;
    }

    public function getSouhaitAt(): ?\DateInterval
    {
        return $this->souhait_at;
    }

    public function setSouhaitAt(\DateInterval $souhait_at): self
    {
        $this->souhait_at = $souhait_at;

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

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }
}
