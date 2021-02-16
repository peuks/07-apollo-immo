<?php

namespace App\Entity;

use App\Repository\DossierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DossierRepository::class)
 */
class Dossier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $piece_identite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $bulletin_de_salaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $justificatif_de_domicile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $avis_imposition_n;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $avis_imposition_n_moins_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $certifications_id_insee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $kbis;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carte_professionelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bilan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attestation_retraite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attestation_allocation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $justificatif_etudiant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avis_titularisation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contrat_travail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attestion_employeur;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="dossier", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPieceIdentite(): ?string
    {
        return $this->piece_identite;
    }

    public function setPieceIdentite(string $piece_identite): self
    {
        $this->piece_identite = $piece_identite;

        return $this;
    }

    public function getBulletinDeSalaire(): ?string
    {
        return $this->bulletin_de_salaire;
    }

    public function setBulletinDeSalaire(string $bulletin_de_salaire): self
    {
        $this->bulletin_de_salaire = $bulletin_de_salaire;

        return $this;
    }

    public function getJustificatifDeDomicile(): ?string
    {
        return $this->justificatif_de_domicile;
    }

    public function setJustificatifDeDomicile(string $justificatif_de_domicile): self
    {
        $this->justificatif_de_domicile = $justificatif_de_domicile;

        return $this;
    }

    public function getAvisImpositionN(): ?string
    {
        return $this->avis_imposition_n;
    }

    public function setAvisImpositionN(string $avis_imposition_n): self
    {
        $this->avis_imposition_n = $avis_imposition_n;

        return $this;
    }

    public function getAvisImpositionNMoins1(): ?string
    {
        return $this->avis_imposition_n_moins_1;
    }

    public function setAvisImpositionNMoins1(string $avis_imposition_n_moins_1): self
    {
        $this->avis_imposition_n_moins_1 = $avis_imposition_n_moins_1;

        return $this;
    }

    public function getCertificationsIdInsee(): ?string
    {
        return $this->certifications_id_insee;
    }

    public function setCertificationsIdInsee(string $certifications_id_insee): self
    {
        $this->certifications_id_insee = $certifications_id_insee;

        return $this;
    }

    public function getKbis(): ?string
    {
        return $this->kbis;
    }

    public function setKbis(?string $kbis): self
    {
        $this->kbis = $kbis;

        return $this;
    }

    public function getCarteProfessionelle(): ?string
    {
        return $this->carte_professionelle;
    }

    public function setCarteProfessionelle(?string $carte_professionelle): self
    {
        $this->carte_professionelle = $carte_professionelle;

        return $this;
    }

    public function getBilan(): ?string
    {
        return $this->bilan;
    }

    public function setBilan(?string $bilan): self
    {
        $this->bilan = $bilan;

        return $this;
    }

    public function getAttestationRetraite(): ?string
    {
        return $this->attestation_retraite;
    }

    public function setAttestationRetraite(?string $attestation_retraite): self
    {
        $this->attestation_retraite = $attestation_retraite;

        return $this;
    }

    public function getAttestationAllocation(): ?string
    {
        return $this->attestation_allocation;
    }

    public function setAttestationAllocation(?string $attestation_allocation): self
    {
        $this->attestation_allocation = $attestation_allocation;

        return $this;
    }

    public function getJustificatifEtudiant(): ?string
    {
        return $this->justificatif_etudiant;
    }

    public function setJustificatifEtudiant(?string $justificatif_etudiant): self
    {
        $this->justificatif_etudiant = $justificatif_etudiant;

        return $this;
    }

    public function getAvisTitularisation(): ?string
    {
        return $this->avis_titularisation;
    }

    public function setAvisTitularisation(?string $avis_titularisation): self
    {
        $this->avis_titularisation = $avis_titularisation;

        return $this;
    }

    public function getContratTravail(): ?string
    {
        return $this->contrat_travail;
    }

    public function setContratTravail(?string $contrat_travail): self
    {
        $this->contrat_travail = $contrat_travail;

        return $this;
    }

    public function getAttestionEmployeur(): ?string
    {
        return $this->attestion_employeur;
    }

    public function setAttestionEmployeur(?string $attestion_employeur): self
    {
        $this->attestion_employeur = $attestion_employeur;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
