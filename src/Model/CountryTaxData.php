<?php

namespace Model;

class CountryTaxData
{
    /**
     * @var int
     */
    public $countryId;

    /**
     * @var float Average tax rate of the country
     */
    public $averageTaxRate;

    /**
     * @var float Overall amount of country taxes
     */
    public $overallTaxAmount;
}
