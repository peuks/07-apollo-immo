<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


class PropertySearch
{
    /**
     * @var int|null
     * La variable peut être un entier ou null si aucune recherche n'est faite
     */
    private $maxPrice;

    /**
     * @var int|null
     * La variable peut être un entier ou null si aucune recherche n'est faite
     * @Assert\Range(min = 10,
     * max = 400)
     */
    private $minSurface;


    /**
     * @var ArrayCollection
     */
    private $specificity;
    public function __construct()
    {
        $this->specificity = new ArrayCollection();
    }
    /**
     * Get la variable peut être un entier ou null si aucune recherche n'est faite
     *
     * @return  int|null
     */
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set la variable peut être un entier ou null si aucune recherche n'est faite
     *
     * @param  int|null  $maxPrice  La variable peut être un entier ou null si aucune recherche n'est faite
     *
     * @return  self
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * Get la variable peut être un entier ou null si aucune recherche n'est faite
     *
     * @return  int|null
     */
    public function getMinSurface()
    {
        return $this->minSurface;
    }

    /**
     * Set la variable peut être un entier ou null si aucune recherche n'est faite
     *
     * @param  int|null  $minSurface  La variable peut être un entier ou null si aucune recherche n'est faite
     *
     * @return  self
     */
    public function setMinSurface(int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;

        return $this;
    }

    /**
     * Get the value of specificities
     *
     * @return  ArrayCollection
     * Will return an empty ArrayCollection getSpecificities is null
     */
    public function getSpecificities()
    {
        return ($this->specificity === null) ?  new ArrayCollection : $this->specificity;
    }

    /**
     * Set the value of specificities
     *
     * @param  ArrayCollection  $specificities
     *
     * @return  self
     */
    public function setSpecificities(ArrayCollection $specificities)
    {
        $this->specificities = $specificities;

        return $this;
    }
}
