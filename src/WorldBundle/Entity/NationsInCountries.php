<?php

namespace WorldBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NationsInCountries
 *
 * @ORM\Table(name="nations_in_countries")
 * @ORM\Entity(repositoryClass="WorldBundle\Repository\NationsInCountriesRepository")
 */
class NationsInCountries
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
	 * @var Country
	 *
	 * @ORM\ManyToOne(targetEntity="Country", inversedBy="nationsInCountries")
	 * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=false)
	 */
    private $country;

	/**
	 * @var Nation
	 *
	 * @ORM\ManyToOne(targetEntity="Nation", inversedBy="nationsInCountries")
	 * @ORM\JoinColumn(name="nation_id", referencedColumnName="id", nullable=false)
	 */
    private $nation;

    /**
     * @var int
     *
     * @ORM\Column(name="population", type="integer")
     */
    private $population;

    public function __construct(Country $country, Nation $nation, $population)
    {
    	$this->country = $country;
    	$this->nation = $nation;
    	$this->population = $population;
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
     * Set population
     *
     * @param integer $population
     *
     * @return NationsInCountries
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
	 * @return Country
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param Country $country
	 */
	public function setCountry(Country $country)
	{
		$this->country = $country;
	}

	/**
	 * @return Nation
	 */
	public function getNation()
	{
		return $this->nation;
	}

	/**
	 * @param Nation $nation
	 */
	public function setNation(Nation $nation)
	{
		$this->nation = $nation;
	}
}

