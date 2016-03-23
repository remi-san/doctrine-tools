<?php

namespace Doctrine\Tools;

use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class Psr3SqlLogger implements SQLLogger
{
    /** @var LoggerInterface */
    private $logger;

    /** @var string */
    private $level;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger
     * @param string          $level
     */
    public function __construct(LoggerInterface $logger = null, $level = LogLevel::DEBUG)
    {
        $this->logger = $logger;
        $this->level = $level;
    }

    /**
     * Logs a SQL statement somewhere.
     *
     * @param string $sql    The SQL to be executed.
     * @param array  $params The SQL parameters.
     * @param array  $types  The SQL parameter types.
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $this->logger && $this->logger->log(
            $this->level,
            'Execute SQL',
            [
                'query' => $sql,
                'params' => $params,
                'types' => $types
            ]
        );
    }

    /**
     * Marks the last started query as stopped. This can be used for timing of queries.
     */
    public function stopQuery()
    {
    }
}
