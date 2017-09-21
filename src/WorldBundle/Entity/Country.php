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
	 * @var ArrayCollection|Nation[]
	 *
	 * @ORM\ManyToMany(targetEntity="Nation", mappedBy="countries")
	 */
    private $nations;

    public function __construct()
    {
    	$this->nations = new ArrayCollection();
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
	 * @param Nation $nation
	 */
	public function addNation(Nation $nation) {
		if ($this->nations->contains($nation)) {
			return;
		}

		$this->nations->add($nation);
	}

	/**
	 * @param Nation $nation
	 */
	public function removeNation(Nation $nation) {
		if (!$this->nations->contains($nation)) {
			return;
		}

		$this->nations->removeElement($nation);
	}

	/**
	 * @return ArrayCollection|Nation[]
	 */
	public function getNations()
	{
		return $this->nations;
	}

	/**
	 * @param ArrayCollection|Nation[] $nations
	 */
	public function setNations($nations)
	{
		$this->nations = $nations;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->name;
	}
}

