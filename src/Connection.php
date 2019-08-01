<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Doctrine helper class to work with the current connection
 */
class Connection
{
    const MODELS_PATHS = [__DIR__ . '/Model'];

    /**
     * @var EntityManager
     */
    private static $entityManager;

    /**
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     */
    public static function getEntityManager(): EntityManager
    {
        if (static::$entityManager === null) {
            $connectionParams = Config::get('connection');
            $config = Setup::createAnnotationMetadataConfiguration(static::MODELS_PATHS, Config::get('debug'));
            return static::$entityManager = EntityManager::create($connectionParams, $config);
        }

        return static::$entityManager;
    }

    /**
     * Apply fixtures to the database.
     *
     * @param AbstractFixture ...$fixtures
     * @throws \Doctrine\ORM\ORMException
     * @throws \Exception\UndefinedConfigParam
     */
    public static function applyFixtures(AbstractFixture ...$fixtures)
    {
        $loader = new Loader();
        foreach ($fixtures as $fixture) {
            $loader->addFixture($fixture);
        }

        $purger = new ORMPurger();
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);
        $executor = new ORMExecutor(static::getEntityManager(), $purger);
        $executor->execute($loader->getFixtures());
    }
}
