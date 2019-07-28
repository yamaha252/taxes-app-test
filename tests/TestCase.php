<?php

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->entityManager = $this->getEntityManager();
        $this->truncateSchema();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->applyFixtures();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../src/Model']);
        $config->setAutoGenerateProxyClasses(true);
        $connection = array(
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
            'dbname' => getenv('DB_NAME'),
        );
        return EntityManager::create($connection, $config);
    }

    protected function truncateSchema() {
        $schema = new SchemaTool($this->entityManager);
        $schema->dropSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
        $schema->createSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
    }

    protected function applyFixtures() {
        $loader = new Loader();
        foreach (static::getFixtures() as $fixture) {
            $loader->addFixture($fixture);
        }

        $purger = new ORMPurger();
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());
    }

    abstract protected static function getFixtures(): iterable;
}
