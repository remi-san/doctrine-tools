<?php

namespace Doctrine\Tools;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;

class EntityManagerBuilder
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Constructor.
     *
     * @param mixed         $conn
     * @param Configuration $config
     */
    public function __construct(
        $conn,
        Configuration $config
    ) {
        $this->entityManager = EntityManager::create($conn, $config);
    }

    /**
     * Add a type.
     *
     * @param string     $name
     * @param string     $className
     * @param callable[] $calls     an array of - [ methodName, [ methodParams... ] ]
     */
    public function addType(
        $name,
        $className,
        array $calls = []
    ) {
        if (!Type::hasType($name)) {
            Type::addType($name, $className);
        } else {
            Type::overrideType($name, $className);
        }

        if (!empty($calls)) {
            $type = self::getType($name);
            foreach ($calls as $call) {
                call_user_func_array([$type, $call[0]], $call[1]);
            }
        }

        $this->entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping($name, $name);
    }

    /**
     * Get the twitter type.
     *
     * @param string $typeName
     *
     * @throws DBALException
     *
     * @return Type
     */
    private static function getType($typeName)
    {
        return Type::getType($typeName);
    }

    /**
     * Builds the entity manager.
     *
     * @return EntityManager
     */
    public function buildEntityManager()
    {
        return $this->entityManager;
    }
}
