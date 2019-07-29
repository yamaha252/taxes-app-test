<?php

namespace Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity(repositoryClass="Repository\Country")
 * @Table(name="countries")
 **/
class Country
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @OneToMany(targetEntity="Model\State", mappedBy="country")
     */
    protected $states;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->states = new ArrayCollection();
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
     * @return country
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
     * Add state.
     *
     * @param State $state
     *
     * @return Country
     */
    public function addState(State $state)
    {
        $this->states[] = $state;

        return $this;
    }

    /**
     * Remove state.
     *
     * @param State $state
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeState(State $state)
    {
        return $this->states->removeElement($state);
    }

    /**
     * Get states.
     *
     * @return Collection<\Model\State>
     */
    public function getStates(): Collection
    {
        return $this->states;
    }
}
