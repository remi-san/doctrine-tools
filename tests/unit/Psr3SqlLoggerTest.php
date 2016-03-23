<?php

namespace Doctrine\Tools\Test;

use Doctrine\Tools\Psr3SqlLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class Psr3SqlLoggerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function setUp()
    {
        $this->logger = \Mockery::mock(LoggerInterface::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function it_should_not_log_anything_if_logger_has_not_been_set()
    {
        $this->logger->shouldReceive('log')->never();
        $logger = new Psr3SqlLogger();
        $logger->startQuery('');
        $logger->stopQuery();
    }

    /**
     * @test
     */
    public function it_should_log_the_query_if_logger_has_been_set()
    {
        $logger = new Psr3SqlLogger($this->logger, LogLevel::INFO);

        $this->logger
            ->shouldReceive('log')
            ->with(
                LogLevel::INFO,
                'Execute SQL',
                [
                    'query' => '',
                    'params' => [],
                    'types' => null
                ]
            )
            ->once();

        $logger->startQuery('', [], null);
        $logger->stopQuery();
    }
}
