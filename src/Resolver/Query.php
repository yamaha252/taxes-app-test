<?php

namespace Resolver;

use Connection;
use Exception\CountryNotFound;
use Exception\CountyNotFound;
use Exception\StateNotFound;
use GraphQL\Type\Definition\ResolveInfo;
use Model\CountryTaxData;
use Model\StateTaxData;

/**
 * Root query resolver
 * @package Resolver
 */
class Query
{
    /**
     * Full countries list.
     *
     * @param $args
     * @param $context
     * @param ResolveInfo $info
     * @return \Model\Country[]
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     */
    public static function countries($args, $context, ResolveInfo $info): array
    {
        $fields = $info->getFieldSelection();
        $entityManager = Connection::getEntityManager();

        /** @var \Repository\Country $repository */
        $repository = $entityManager->getRepository(\Model\Country::class);
        $result = $repository->findAll();

        if (isset($fields['averageTaxRate']) || isset($fields['overallTaxAmount'])) {
            $taxData = $repository->getAllTaxData();
            $result = array_map(function ($item) use ($taxData) {
                /** @var \Model\Country $item */
                $item->setTaxData($taxData[$item->getId()] ?? new CountryTaxData());
                return $item;
            }, $result);
        }

        return $result;
    }

    /**
     * Country by arrgs.
     *
     * @param $args
     * @param $context
     * @param ResolveInfo $info
     * @return \Model\Country
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     * @throws CountryNotFound
     */
    public static function country($args, $context, ResolveInfo $info): \Model\Country
    {
        $fields = $info->getFieldSelection();
        $entityManager = Connection::getEntityManager();
        $repository = $entityManager->getRepository(\Model\Country::class);

        /** @var \Model\Country $result */
        $result = $repository->findOneBy($args);

        if (!$result) {
            throw new CountryNotFound('Country not found');
        }

        $taxData = new CountryTaxData();
        if (isset($fields['averageTaxRate'])) {
            $taxData->averageTaxRate = $repository->getAverageTaxRate($result->getId());
        }
        if (isset($fields['overallTaxAmount'])) {
            $taxData->overallTaxAmount = $repository->getOverallTaxAmount($result->getId());
        }
        $result->setTaxData($taxData);

        return $result;
    }

    /**
     * Full states list.
     *
     * @param $args
     * @param $context
     * @param ResolveInfo $info
     * @return \Model\State[]
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     */
    public static function states($args, $context, ResolveInfo $info): array
    {
        $fields = $info->getFieldSelection();
        $entityManager = Connection::getEntityManager();

        /** @var \Repository\State $repository */
        $repository = $entityManager->getRepository(\Model\State::class);
        $result = $repository->findAll();

        if (isset($fields['overallTaxAmount']) || isset($fields['averageTaxAmount']) || isset($fields['averageTaxRate'])) {
            $taxData = $repository->getAllTaxData();
            $result = array_map(function ($item) use ($taxData) {
                /** @var \Model\State $item */
                $item->setTaxData($taxData[$item->getId()] ?? new StateTaxData());
                return $item;
            }, $result);
        }

        return $result;
    }

    /**
     * State by arrgs.
     *
     * @param $args
     * @param $context
     * @param ResolveInfo $info
     * @return \Model\State
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     * @throws StateNotFound
     */
    public static function state($args, $context, ResolveInfo $info): \Model\State
    {
        $fields = $info->getFieldSelection();
        $entityManager = Connection::getEntityManager();

        /** @var \Repository\State $repository */
        $repository = $entityManager->getRepository(\Model\State::class);

        /** @var \Model\State $result */
        $result = $repository->findOneBy($args);

        if (!$result) {
            throw new StateNotFound('State not found');
        }

        $taxData = new StateTaxData();
        if (isset($fields['overallTaxAmount'])) {
            $taxData->overallTaxAmount = $repository->getOverallTaxAmount($result->getId());
        }
        if (isset($fields['averageTaxAmount'])) {
            $taxData->averageTaxAmount = $repository->getAverageTaxAmount($result->getId());
        }
        if (isset($fields['averageTaxRate'])) {
            $taxData->averageTaxRate = $repository->getAverageTaxRate($result->getId());
        }

        $result->setTaxData($taxData);

        return $result;
    }

    /**
     * Full counties list.
     *
     * @return \Model\County[]
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     */
    public static function counties(): array
    {
        $entityManager = Connection::getEntityManager();
        $repository = $entityManager->getRepository(\Model\County::class);
        return $repository->findAll();
    }

    /**
     * County by id.
     *
     * @param $args
     * @return \Model\County
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     * @throws CountyNotFound
     */
    public static function county($args): \Model\County
    {
        $entityManager = Connection::getEntityManager();
        $repository = $entityManager->getRepository(\Model\County::class);

        /** @var \Model\County $result */
        $result = $repository->findOneBy($args);

        if (!$result) {
            throw new CountyNotFound('Country not found');
        }

        return $result;
    }
}
