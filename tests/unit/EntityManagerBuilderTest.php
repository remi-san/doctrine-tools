<?php

namespace Doctrine\Tools\Test;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\Tools\EntityManagerBuilder;
use Doctrine\Tools\test\stub\DummyType;

class EntityManagerBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var  */
    private $connection;

    /** @var Configuration */
    private $config;

    public function setUp()
    {
        $this->connection = ['url' => 'sqlite:///test.sqlite'];
        $this->config = Setup::createYAMLMetadataConfiguration([], false);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function it_should_return_the_EntityManager_when_building()
    {
        $builder = new EntityManagerBuilder($this->connection, $this->config);
        $this->assertInstanceOf(EntityManager::class, $builder->buildEntityManager());
    }

    /**
     * @test
     */
    public function it_is_possible_to_add_a_type_to_the_EntityManager()
    {
        $builder = new EntityManagerBuilder($this->connection, $this->config);
        $builder->addType('dummy', DummyType::class);
        $entityManager = $builder->buildEntityManager();

        $this->assertInstanceOf(EntityManager::class, $entityManager);
        $this->assertEquals(
            'dummy',
            $entityManager->getConnection()->getDatabasePlatform()->getDoctrineTypeMapping('dummy')
        );
        $this->assertFalse(DummyType::$called);
    }

    /**
     * @test
     */
    public function it_is_possible_to_add_a_type_to_the_EntityManager_and_call_a_method_to_init_it()
    {
        $builder = new EntityManagerBuilder($this->connection, $this->config);
        $builder->addType('dummy', DummyType::class, [ [ 'callTypeMethod', []] ]);
        $entityManager = $builder->buildEntityManager();

        $this->assertInstanceOf(EntityManager::class, $entityManager);
        $this->assertEquals(
            'dummy',
            $entityManager->getConnection()->getDatabasePlatform()->getDoctrineTypeMapping('dummy')
        );
        $this->assertTrue(DummyType::$called);
    }
}
