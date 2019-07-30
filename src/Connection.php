<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Connect to the database and return EntityManager to work with
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
            $config = Setup::createAnnotationMetadataConfiguration(static::MODELS_PATHS);
            $config->setAutoGenerateProxyClasses(true);
            return static::$entityManager = EntityManager::create($connectionParams, $config);
        }

        return static::$entityManager;
    }
}
