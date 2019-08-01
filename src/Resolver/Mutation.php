<?php

namespace Resolver;

use Connection;

class Mutation
{
    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     */
    public static function generateData()
    {
        Connection::applyFixtures(...[
            new \Fixture\Country,
            new \Fixture\State,
            new \Fixture\County,
        ]);
        return true;
    }
}
