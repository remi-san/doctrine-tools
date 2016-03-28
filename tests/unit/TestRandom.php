<?php
namespace Doctrine\Tools\Test;

use Doctrine\ORM\Query\QueryException;
use Doctrine\Tools\Random;

class TestRandom extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     * @throws QueryException
     */
    public function testRandomMySql()
    {

        $parser = \Mockery::mock('\\Doctrine\\ORM\\Query\\Parser');
        $parser->shouldReceive('match')->times(3);

        $platform = \Mockery::mock('\\Doctrine\\DBAL\\Platforms\\AbstractPlatform');
        $platform->shouldReceive('getName')->andReturn('mysql');

        $connection = \Mockery::mock('\\Doctrine\\DBAL\\Connection');
        $connection->shouldReceive('getDatabasePlatform')->andReturn($platform);

        $walker = \Mockery::mock('\\Doctrine\\ORM\\Query\\SqlWalker');
        $walker->shouldReceive('getConnection')->andReturn($connection);

        $random = new Random('random');
        $random->parse($parser);

        $this->assertEquals('RAND()', $random->getSql($walker));
    }

    /**
     * @test
     * @throws QueryException
     */
    public function testRandomPostgresql()
    {

        $parser = \Mockery::mock('\\Doctrine\\ORM\\Query\\Parser');
        $parser->shouldReceive('match')->times(3);

        $platform = \Mockery::mock('\\Doctrine\\DBAL\\Platforms\\AbstractPlatform');
        $platform->shouldReceive('getName')->andReturn('postgresql');

        $connection = \Mockery::mock('\\Doctrine\\DBAL\\Connection');
        $connection->shouldReceive('getDatabasePlatform')->andReturn($platform);

        $walker = \Mockery::mock('\\Doctrine\\ORM\\Query\\SqlWalker');
        $walker->shouldReceive('getConnection')->andReturn($connection);

        $random = new Random('random');
        $random->parse($parser);

        $this->assertEquals('RANDOM()', $random->getSql($walker));
    }

    /**
     * @test
     * @throws QueryException
     */
    public function testRandomOracle()
    {

        $this->setExpectedException('\\Doctrine\\ORM\\Query\\QueryException');

        $parser = \Mockery::mock('\\Doctrine\\ORM\\Query\\Parser');
        $parser->shouldReceive('match')->times(3);

        $platform = \Mockery::mock('\\Doctrine\\DBAL\\Platforms\\AbstractPlatform');
        $platform->shouldReceive('getName')->andReturn('oracle');

        $connection = \Mockery::mock('\\Doctrine\\DBAL\\Connection');
        $connection->shouldReceive('getDatabasePlatform')->andReturn($platform);

        $walker = \Mockery::mock('\\Doctrine\\ORM\\Query\\SqlWalker');
        $walker->shouldReceive('getConnection')->andReturn($connection);

        $random = new Random('random');
        $random->parse($parser);

        $random->getSql($walker);
    }
}
