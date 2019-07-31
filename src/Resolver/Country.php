<?php

namespace Resolver;

use Doctrine\Common\Collections\Collection;

/**
 * Country resolver
 * @package Resolver
 */
class Country
{
    /**
     * @param \Model\Country $model
     * @return int
     */
    public static function id(\Model\Country $model): int
    {
        return $model->getId();
    }

    /**
     * @param \Model\Country $model
     * @return string
     */
    public static function name(\Model\Country $model): string
    {
        return $model->getName();
    }

    /**
     * @param \Model\Country $model
     * @return float | null
     */
    public static function averageTaxRate(\Model\Country $model)
    {
        return $model->getTaxData()->averageTaxRate;
    }

    /**
     * @param \Model\Country $model
     * @return float | null
     */
    public static function overallTaxAmount(\Model\Country $model)
    {
        return $model->getTaxData()->overallTaxAmount;
    }

    /**
     * @param \Model\Country $model
     * @return Collection
     */
    public static function states(\Model\Country $model): Collection
    {
        return $model->getStates();
    }
}
