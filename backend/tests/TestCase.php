<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @inheritDoc
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::applyFixtures();
    }

    /**
     * Apply described in `getFixtures` fixtures to the database.
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     */
    protected static function applyFixtures()
    {
        $fixtures = static::getFixtures();
        Connection::applyFixtures(...$fixtures);
    }

    /**
     * @return AbstractFixture[]
     */
    abstract protected static function getFixtures(): iterable;
}
