<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Model\CountryTaxData;
use Model\County;
use Model\State;

class Country extends EntityRepository
{
    /**
     * Tax data of all the countries
     *
     * @return CountryTaxData[]
     */
    function getAllTaxData(): array
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select(
                'IDENTITY(s.country) countryId',
                'AVG(c.taxRate) averageTaxRate',
                'SUM(c.taxAmount) overallTaxAmount'
            )
            ->from(County::class, 'c')
            ->leftJoin(State::class, 's', Join::WITH, 's.id=c.state')
            ->groupBy('s.country')
            ->getQuery();

        $result = $query->getArrayResult();
        return array_map(function (array $item) {
            $result = new CountryTaxData;
            $result->countryId = (int)$item['countryId'];
            $result->averageTaxRate = (float)$item['averageTaxRate'];
            $result->overallTaxAmount = (float)$item['overallTaxAmount'];
            return $result;
        }, $result);
    }

    /**
     * Average tax rate of the country
     *
     * @param int $countryId
     * @return float
     * @throws NonUniqueResultException
     */
    function getAverageTaxRate(int $countryId): float
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('AVG(c.taxRate)')
            ->from(County::class, 'c')
            ->leftJoin(State::class, 's', Join::WITH, 's.id=c.state')
            ->where('s.country=:countryId')
            ->setParameter('countryId', $countryId)
            ->getQuery();
        return $query->getSingleScalarResult() ?? 0;
    }

    /**
     * Overall amount of country taxes
     *
     * @param int $countryId
     * @return float
     * @throws NonUniqueResultException
     */
    function getOverallTaxAmount(int $countryId): float
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('SUM(c.taxAmount)')
            ->from(County::class, 'c')
            ->leftJoin(State::class, 's', Join::WITH, 's.id=c.state')
            ->where('s.country=:countryId')
            ->setParameter('countryId', $countryId)
            ->getQuery();
        return $query->getSingleScalarResult() ?? 0;
    }
}
