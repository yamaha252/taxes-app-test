<?php

namespace Resolver;

/**
 * County resolver
 * @package Resolver
 */
class County
{
    /**
     * @param \Model\County $model
     * @return int
     */
    public static function id(\Model\County $model): int
    {
        return $model->getId();
    }

    /**
     * @param \Model\County $model
     * @return string
     */
    public static function name(\Model\County $model): string
    {
        return $model->getName();
    }

    /**
     * @param \Model\County $model
     * @return float
     */
    public static function taxRate(\Model\County $model): float
    {
        return $model->getTaxRate();
    }

    /**
     * @param \Model\County $model
     * @return float
     */
    public static function taxAmount(\Model\County $model): float
    {
        return $model->getTaxAmount();
    }

    /**
     * @param \Model\County $model
     * @return \Model\State
     */
    public static function state(\Model\County $model): \Model\State
    {
        return $model->getState();
    }
}
