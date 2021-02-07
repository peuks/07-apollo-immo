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
    private $options;
    public function __construct()
    {
        $this->option = new ArrayCollection();
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
     * Get the value of options
     *
     * @return  ArrayCollection
     * Will return an empty ArrayCollection getOptions is null
     */
    public function getOptions()
    {
        return ($this->options === null) ?  new ArrayCollection : $this->options;
    }

    /**
     * Set the value of options
     *
     * @param  ArrayCollection  $options
     *
     * @return  self
     */
    public function setOptions(ArrayCollection $options)
    {
        $this->options = $options;

        return $this;
    }
}
