<?php

namespace Doctrine\Tools;

use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Log\LoggerInterface;

class Psr3SqlLogger implements SQLLogger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
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
        $this->logger && $this->logger->debug(
            'Execute SQL',
            array(
                'query' => $sql,
                'params' => $params,
                'types' => $types,
            )
        );
    }

    /**
     * Marks the last started query as stopped. This can be used for timing of queries.
     */
    public function stopQuery()
    {
    }
}
