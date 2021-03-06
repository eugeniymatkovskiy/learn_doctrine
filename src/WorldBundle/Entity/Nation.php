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
	 * @var ArrayCollection|NationsInCountries[]
	 *
	 * @ORM\OneToMany(targetEntity="NationsInCountries", mappedBy="nation")
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
	 * @param NationsInCountries $nationsInCountries
	 */
	public function addCountry(NationsInCountries $nationsInCountries) {
		if ($this->nationsInCountries->contains($nationsInCountries)) {
			return;
		}

		$this->nationsInCountries->add($nationsInCountries);
	}

	/**
	 * @param NationsInCountries $nationsInCountries
	 */
	public function removeCountry(NationsInCountries $nationsInCountries) {
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
}

