<?php

namespace WorldBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Continent
 *
 * @ORM\Table(name="continent")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\ContinentRepository")
 */
class Continent
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
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

	/**
	 * @var ArrayCollection|Country[]
	 *
	 * @ORM\OneToMany(targetEntity="Country", mappedBy="continent")
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
     * Set name
     *
     * @param string $name
     *
     * @return Continent
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

	/**
	 * @param Country $country
	 * @return Continent
	 */
    public function addCountry(Country $country) {
    	if ($this->countries->contains($country)) {
    		return $this;
	    }

	    $this->countries->add($country);
    	return $this;
    }

	/**
	 * @param Country $country
	 * @return Continent
	 */
    public function removeCountry(Country $country) {
    	if ($this->countries->contains($country)) {
    		$this->countries->removeElement($country);
	    }

	    return $this;
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

	public function __toString()
	{
		return $this->name;
	}
}

