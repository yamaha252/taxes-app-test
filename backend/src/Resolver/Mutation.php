<?php

namespace Resolver;

use Connection;

class Mutation
{
    /**
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     */
    public static function generateData()
    {
        Connection::applyFixtures(...[
            new \Fixture\Country,
            new \Fixture\StateRandom,
            new \Fixture\CountyRandom,
        ]);
        return [];
    }
}
