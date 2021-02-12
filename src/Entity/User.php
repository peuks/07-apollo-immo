<?php

namespace App\Entity;

use App\Entity\Articles;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity=Agence::class, mappedBy="user")
     */
    private $agencies;

    /**
     * @ORM\OneToMany(targetEntity=Travailler::class, mappedBy="user")
     */
    private $travaillers;

    public function __construct()
    {
        $this->agencies = new ArrayCollection();
        $this->travaillers = new ArrayCollection();
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

    /**
     * @return Collection|Agence[]
     */
    public function getAgencies(): Collection
    {
        return $this->agencies;
    }

    public function addAgency(Agence $agency): self
    {
        if (!$this->agencies->contains($agency)) {
            $this->agencies[] = $agency;
            $agency->addUser($this);
        }

        return $this;
    }

    public function removeAgency(Agence $agency): self
    {
        if ($this->agencies->removeElement($agency)) {
            $agency->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Travailler[]
     */
    public function getTravaillers(): Collection
    {
        return $this->travaillers;
    }

    public function addTravailler(Travailler $travailler): self
    {
        if (!$this->travaillers->contains($travailler)) {
            $this->travaillers[] = $travailler;
            $travailler->setUser($this);
        }

        return $this;
    }

    public function removeTravailler(Travailler $travailler): self
    {
        if ($this->travaillers->removeElement($travailler)) {
            // set the owning side to null (unless already changed)
            if ($travailler->getUser() === $this) {
                $travailler->setUser(null);
            }
        }

        return $this;
    }
}
