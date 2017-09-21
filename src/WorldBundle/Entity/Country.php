<?php

namespace WorldBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\CountryRepository")
 */
class Country
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

	/**
	 * @var Continent
	 *
	 * @ORM\ManyToOne(targetEntity="Continent", inversedBy="countries")
	 * @ORM\JoinColumn(name="continent_id", referencedColumnName="id", nullable=false)
	 */
    private $continent;

	/**
	 * @var ArrayCollection|NationsInCountries[]
	 *
	 * @ORM\OneToMany(targetEntity="NationsInCountries", mappedBy="country")
	 */
    private $nationsInCountries;

    public function __construct()
    {
    	$this->nationsInCountries = new ArrayCollection();
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
     * @return Country
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
	 * @return Continent
	 */
	public function getContinent()
	{
		return $this->continent;
	}

	/**
	 * @param Continent $continent
	 */
	public function setContinent(Continent $continent)
	{
		$this->continent = $continent;
	}


	/**
	 * @param NationsInCountries $nationsInCountries
	 */
	public function addNation(NationsInCountries $nationsInCountries) {
		if ($this->nationsInCountries->contains($nationsInCountries)) {
			return;
		}

		$this->nationsInCountries->add($nationsInCountries);
	}

	/**
	 * @param NationsInCountries $nationsInCountries
	 */
	public function removeNation(NationsInCountries $nationsInCountries) {
		if (!$this->nationsInCountries->contains($nationsInCountries)) {
			return;
		}

		$this->nationsInCountries->removeElement($nationsInCountries);
	}

	/**
	 * @return ArrayCollection|NationsInCountries[]
	 */
	public function getNationsInCountries()
	{
		return $this->nationsInCountries;
	}

	/**
	 * @param ArrayCollection|NationsInCountries[] $nationsInCountries
	 */
	public function setNationsInCountries($nationsInCountries)
	{
		$this->nationsInCountries = $nationsInCountries;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->name;
	}
}

