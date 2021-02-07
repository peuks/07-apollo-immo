<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Validation
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Unique;



/**
 * @ORM\Entity(repositoryClass=PropertyRepository::class)
 */
class Property
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     * min = 3,
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    public $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer");
     * @Assert\Range(
     *      min = 10,
     *      max = 1000,
     * 
     *      notInRangeMessage = "La surface doit être comprise entre {{ min }}m² et {{ max }}m²",
     * )
     */
    private $surface;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     * min = 1,
     * max = 100,
     * minMessage= "Vous devez renseigner au minimum {{ min }} pièce",
     * maxMessage= "Vous devez renseigner au maximum {{ max }} pièce",
     * )
     */
    private $rooms;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     * min = 1,
     * max = 100,
     * minMessage= "Vous devez renseigner au minimum {{ min }} chambre",
     * maxMessage= "Vous ne pouvez renseigner maximum {{ max }} chambres",
     * )
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     * min = 0,
     * max = 20,
     * minMessage= "L'étage ne peut pas négatif",
     * maxMessage= "L'étage ne peut pas être supérieur à 10",
     * )
     */
    private $floor;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "La ville ne peut contenir moins de  {{ limit }} caractères.",
     *      maxMessage = "La ville ne peut contenir plus de  {{ limit }} caractères.",
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/^[0-9]{5}$/")
     */
    private $postale_code;

    /**
     * @ORM\Column(type="boolean", options ={"default":false}))
     */
    private $sold;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Heat::class, inversedBy="properties")
     */
    public $heat;

    /**
     * @ORM\ManyToMany(targetEntity=Option::class, inversedBy="properties")
     * 
     */

    private $options;

    public function __construct()
    {
        // set creat_at default value at actual time
        $this->created_at = new \DateTime();

        // set default value of sold to false
        $this->sold = false;
        $this->options = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }




    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostaleCode(): ?int
    {
        return $this->postale_code;
    }

    public function setPostaleCode(int $postale_code): self
    {
        $this->postale_code = $postale_code;

        return $this;
    }

    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, '', ' ');
    }


    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = (new Slugify())->slugify(strtolower($slug));

        return $this;
    }

    public function getHeatType(): string
    {
        return $this->heat->getType();
    }

    public function setHeatType(?Heat $heat): self
    {
        $this->heat = $heat;

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->addProperty($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->removeElement($option)) {
            $option->removeProperty($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
