<?php

namespace App\Entity;

use App\Repository\AgenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 */
class Agence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $raison_sociale;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_commercial;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $responsable_agence;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raison_sociale;
    }

    public function setRaisonSociale(string $raison_sociale): self
    {
        $this->raison_sociale = $raison_sociale;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getNomCommercial(): ?string
    {
        return $this->nom_commercial;
    }

    public function setNomCommercial(string $nom_commercial): self
    {
        $this->nom_commercial = $nom_commercial;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?int
    {
        return $this->mail;
    }

    public function setMail(int $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getResponsableAgence(): ?string
    {
        return $this->responsable_agence;
    }

    public function setResponsableAgence(string $responsable_agence): self
    {
        $this->responsable_agence = $responsable_agence;

        return $this;
    }
}
