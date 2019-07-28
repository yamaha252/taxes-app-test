<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Model\County;
use Model\StateTaxData;

class State extends EntityRepository
{
    /**
     * Tax data of all the states
     *
     * @return StateTaxData[]
     */
    function getAllTaxData()
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select(
                'IDENTITY(c.state) stateId',
                'SUM(c.taxAmount) overallTaxAmount',
                'AVG(c.taxAmount) averageTaxAmount',
                'AVG(c.taxRate) averageTaxRate'
            )
            ->from(County::class, 'c')
            ->groupBy('c.state')
            ->getQuery();

        $result = $query->getArrayResult();
        return array_map(function (array $item) {
            $result = new StateTaxData;
            $result->stateId = (int)$item['stateId'];
            $result->overallTaxAmount = (float)$item['overallTaxAmount'];
            $result->averageTaxAmount = (float)$item['averageTaxAmount'];
            $result->averageTaxRate = (float)$item['averageTaxRate'];
            return $result;
        }, $result);
    }

    /**
     * Overall amount of state taxes
     *
     * @param int $stateId
     * @return float
     * @throws NonUniqueResultException
     */
    function getOverallTaxAmount(int $stateId): float
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('SUM(c.taxAmount)')
            ->from(County::class, 'c')
            ->where('c.state=:stateId')
            ->setParameter('stateId', $stateId)
            ->getQuery();
        return $query->getSingleScalarResult() ?? 0;
    }

    /**
     * Average amount of state taxes
     *
     * @param int $stateId
     * @return float
     * @throws NonUniqueResultException
     */
    function getAverageTaxAmount(int $stateId): float
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('AVG(c.taxAmount)')
            ->from(County::class, 'c')
            ->where('c.state=:stateId')
            ->setParameter('stateId', $stateId)
            ->getQuery();
        return $query->getSingleScalarResult() ?? 0;
    }

    /**
     * Average tax rate of state
     *
     * @param int $stateId
     * @return float
     * @throws NonUniqueResultException
     */
    function getAverageTaxRate(int $stateId): float
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('AVG(c.taxRate)')
            ->from(County::class, 'c')
            ->where('c.state=:stateId')
            ->setParameter('stateId', $stateId)
            ->getQuery();
        return $query->getSingleScalarResult() ?? 0;
    }
}
