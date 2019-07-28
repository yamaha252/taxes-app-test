<?php

namespace Model;

/**
 * @Entity
 * @Table(name="counties")
 **/
class County
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Model\State")
     */
    protected $state;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @Column(type="float", name="tax_rate")
     */
    protected $taxRate;

    /**
     * @Column(type="float", name="tax_amount")
     */
    protected $taxAmount;

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
     * @return County
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
     * Set taxRate.
     *
     * @param float $taxRate
     *
     * @return County
     */
    public function setTaxRate(float $taxRate)
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    /**
     * Get taxRate.
     *
     * @return float
     */
    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    /**
     * Set taxAmount.
     *
     * @param float $taxAmount
     *
     * @return County
     */
    public function setTaxAmount(float $taxAmount)
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    /**
     * Get taxAmount.
     *
     * @return float
     */
    public function getTaxAmount(): float
    {
        return $this->taxAmount;
    }

    /**
     * Set state.
     *
     * @param State|null $state
     *
     * @return County
     */
    public function setState(State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return State|null
     */
    public function getState(): State
    {
        return $this->state;
    }
}
