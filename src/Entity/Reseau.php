<?php

namespace App\Entity;

use App\Repository\ReseauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReseauRepository::class)
 */
class Reseau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Agence::class, mappedBy="reseau")
     */
    private $agence;

    public function __construct()
    {
        $this->agence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Agence[]
     */
    public function getAgence(): Collection
    {
        return $this->agence;
    }

    public function addAgence(Agence $agence): self
    {
        if (!$this->agence->contains($agence)) {
            $this->agence[] = $agence;
            $agence->setReseau($this);
        }

        return $this;
    }

    public function removeAgence(Agence $agence): self
    {
        if ($this->agence->removeElement($agence)) {
            // set the owning side to null (unless already changed)
            if ($agence->getReseau() === $this) {
                $agence->setReseau(null);
            }
        }

        return $this;
    }
}
