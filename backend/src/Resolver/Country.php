<?php

namespace Resolver;

use Connection;
use Doctrine\Common\Collections\Collection;
use GraphQL\Type\Definition\ResolveInfo;
use Model\StateTaxData;

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
     * @param $args
     * @param $context
     * @param ResolveInfo $info
     * @return Collection
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     */
    public static function states(\Model\Country $model, $args, $context, ResolveInfo $info): iterable
    {
        $result = $model->getStates()->toArray();

        $fields = $info->getFieldSelection();
        if (isset($fields['overallTaxAmount']) || isset($fields['averageTaxAmount']) || isset($fields['averageTaxRate'])) {
            /** @var \Repository\State $repository */
            $repository = Connection::getEntityManager()->getRepository(\Model\State::class);
            $taxData = $repository->getAllTaxData();
            $result = array_map(function ($item) use ($taxData) {
                /** @var \Model\State $item */
                $item->setTaxData($taxData[$item->getId()] ?? new StateTaxData());
                return $item;
            }, $result);
        }

        return $result;
    }
}
