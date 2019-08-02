<?php

namespace Resolver;

use Doctrine\Common\Collections\Collection;

/**
 * State resolver
 * @package Resolver
 */
class State
{
    /**
     * @param \Model\State $model
     * @return int
     */
    public static function id(\Model\State $model): int
    {
        return $model->getId();
    }

    /**
     * @param \Model\State $model
     * @return string
     */
    public static function name(\Model\State $model): string
    {
        return $model->getName();
    }

    /**
     * @param \Model\State $model
     * @return float | null
     */
    public static function overallTaxAmount(\Model\State $model)
    {
        return $model->getTaxData()->overallTaxAmount;
    }

    /**
     * @param \Model\State $model
     * @return float | null
     */
    public static function averageTaxAmount(\Model\State $model)
    {
        return $model->getTaxData()->averageTaxAmount;
    }

    /**
     * @param \Model\State $model
     * @return float | null
     */
    public static function averageTaxRate(\Model\State $model)
    {
        return $model->getTaxData()->averageTaxRate;
    }

    /**
     * @param \Model\State $model
     * @return \Model\Country
     */
    public static function country(\Model\State $model): \Model\Country
    {
        return $model->getCountry();
    }

    /**
     * @param \Model\State $model
     * @return Collection
     */
    public static function counties(\Model\State $model): Collection
    {
        return $model->getCounties();
    }
}
