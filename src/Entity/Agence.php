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
     * @ORM\Column(type="string", length=100)
     */
    private $raison_sociale;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom_commercial;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse_postale;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $responsable_agence;

    /**
     * @ORM\ManyToOne(targetEntity=Travailler::class, inversedBy="agency")
     */
    private $travailler;

    /**
     * @ORM\ManyToOne(targetEntity=Reseau::class, inversedBy="agence")
     */
    private $reseau;

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

    public function getAdressePostale(): ?string
    {
        return $this->adresse_postale;
    }

    public function setAdressePostale(string $adresse_postale): self
    {
        $this->adresse_postale = $adresse_postale;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
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

    public function getTravailler(): ?Travailler
    {
        return $this->travailler;
    }

    public function setTravailler(?Travailler $travailler): self
    {
        $this->travailler = $travailler;

        return $this;
    }

    public function getReseau(): ?Reseau
    {
        return $this->reseau;
    }

    public function setReseau(?Reseau $reseau): self
    {
        $this->reseau = $reseau;

        return $this;
    }
}
