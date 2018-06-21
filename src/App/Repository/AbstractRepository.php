<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Repository;

use App\Component\Database\Connection;

/**
 * Abstract Repository
 *
 * @package App\Repository
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * Abstract Repository constructor
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * @param object $object
     * @param int $id
     * @throws \ReflectionException
     */
    public function bindIdModel($object, int $id): void
    {
        if (is_object($object)) {
            $reflection = new \ReflectionProperty(get_class($object), 'id');
            $reflection->setAccessible(true);
            $reflection->setValue($object, $id);
            $reflection->setAccessible(false);
        }
    }
}
