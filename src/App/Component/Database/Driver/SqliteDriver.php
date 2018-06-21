<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Component\Database\Driver;

use App\Exception\Component\Database\Driver\InvalidArgumentsException;
use App\Exception\Component\Database\Driver\Sqlite\ConnectionException;
use App\Exception\Component\Database\Driver\Sqlite\FileNotFoundException;

/**
 * Sqlite Driver
 *
 * @package App\Component\Database\Driver
 */
class SqliteDriver implements DriverInterface
{
    /**
     * prefix
     */
    const PREFIX = 'sqlite:';

    /**
     * @var string
     */
    private $filePath;

    /**
     * SqliteDriver constructor
     *
     * @param array $config
     * @throws InvalidArgumentsException
     * @throws FileNotFoundException
     */
    public function __construct(array $config)
    {
        if (!self::isValidConfigArray($config)) {
            throw new InvalidArgumentsException(
                sprintf(
                    'Invalid sqlite driver config params, %s',
                    implode(', ', $config)
                )
            );
        }

        $filePath = $config['filePath'];

        if (!file_exists($filePath)) {
            throw new FileNotFoundException(
                sprintf(
                    'database filepath not found: %s',
                    $filePath
                )
            );
        }

        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @return string
     */
    public function getDsn(): string
    {
        return self::PREFIX . $this->getFilePath();
    }

    /**
     * {@inheritdoc}
     */
    public function getConnection(): \PDO
    {
        $pdo = new \PDO($this->getDsn());

        if (!$pdo) {
            throw new ConnectionException(
                sprintf(
                    'Fail to connect on sqlite dsn %s: %s',
                    $this->getDsn(),
                    $pdo->errorInfo()
                )
            );
        }

        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    /**
     * {@inheritdoc}
     */
    public static function isValidConfigArray(array $config): bool
    {
        return isset($config['filePath']);
    }
}
