<?php

namespace WorldBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Nation
 *
 * @ORM\Table(name="nation")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\NationRepository")
 */
class Nation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50, unique=true)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="population", type="integer")
     */
    private $population;

	/**
	 * @var ArrayCollection|Country[]
	 *
	 * @ORM\ManyToMany(targetEntity="Country", inversedBy="nations")
	 */
    private $countries;

    public function __construct()
    {
    	$this->countries = new ArrayCollection();
    }


	/**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Nation
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set population
     *
     * @param integer $population
     *
     * @return Nation
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return int
     */
    public function getPopulation()
    {
        return $this->population;
    }

	/**
	 * @param Country $country
	 */
	public function addCountry(Country $country) {
		if ($this->countries->contains($country)) {
			return;
		}

		$this->countries->add($country);
	}

	/**
	 * @param Country $country
	 */
	public function removeCountry(Country $country) {
		if (!$this->countries->contains($country)) {
			return;
		}

		$this->countries->removeElement($country);
	}

	/**
	 * @return ArrayCollection|Country[]
	 */
	public function getCountries()
	{
		return $this->countries;
	}

	/**
	 * @param ArrayCollection|Country[] $countries
	 */
	public function setCountries($countries)
	{
		$this->countries = $countries;
	}
}

