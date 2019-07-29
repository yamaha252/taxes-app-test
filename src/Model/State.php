<?php

namespace Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity(repositoryClass="Repository\State")
 * @Table(name="states")
 **/
class State
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue *
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @ManyToOne(targetEntity="Model\Country")
     */
    protected $country;

    /**
     * @OneToMany(targetEntity="Model\County", mappedBy="state")
     */
    protected $counties;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->counties = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return State
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set country.
     *
     * @param Country|null $country
     *
     * @return State
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return Country|null
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * Add county.
     *
     * @param County $county
     *
     * @return State
     */
    public function addCounty(County $county)
    {
        $this->counties[] = $county;

        return $this;
    }

    /**
     * Remove county.
     *
     * @param County $county
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCounty(County $county)
    {
        return $this->counties->removeElement($county);
    }

    /**
     * Get counties.
     *
     * @return Collection<\Model\County>
     */
    public function getCounties(): Collection
    {
        return $this->counties;
    }
}
