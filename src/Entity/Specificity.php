<?php

namespace App\Entity;

use App\Repository\SpecificityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpecificityRepository::class)
 */
class Specificity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;


    /**
     * @ORM\ManyToOne(targetEntity=Specificity::class, inversedBy="specificities")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Specificity::class, mappedBy="parent")
     */
    private $specificities;

    public function __construct()
    {
        $this->specificities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSpecificities(): Collection
    {
        return $this->specificities;
    }

    public function addSpecificity(self $specificity): self
    {
        if (!$this->specificities->contains($specificity)) {
            $this->specificities[] = $specificity;
            $specificity->setParent($this);
        }

        return $this;
    }

    public function removeSpecificity(self $specificity): self
    {
        if ($this->specificities->removeElement($specificity)) {
            // set the owning side to null (unless already changed)
            if ($specificity->getParent() === $this) {
                $specificity->setParent(null);
            }
        }

        return $this;
    }
}
