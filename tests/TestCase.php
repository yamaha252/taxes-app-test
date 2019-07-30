<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * TestCase constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\Tools\ToolsException
     * @throws \Exception\UndefinedConfigParam
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->entityManager = Connection::getEntityManager();
        $this->truncateSchema();
    }

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->applyFixtures();
    }

    /**
     * Drop and create database schema
     *
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    protected function truncateSchema()
    {
        $schema = new SchemaTool($this->entityManager);
        $schema->dropSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
        $schema->createSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
    }

    /**
     * Apply described in `getFixtures` fixtures to the database
     */
    protected function applyFixtures()
    {
        $loader = new Loader();
        foreach (static::getFixtures() as $fixture) {
            $loader->addFixture($fixture);
        }

        $purger = new ORMPurger();
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }

    /**
     * @return AbstractFixture[]
     */
    abstract protected static function getFixtures(): iterable;
}
