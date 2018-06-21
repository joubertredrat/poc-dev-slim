<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Component\Database\Driver;

/**
 * Driver Interface
 *
 * @package App\Component\Database\Driver
 */
interface DriverInterface
{
    /**
     * Returns connection
     *
     * @return \PDO
     */
    public function getConnection(): \PDO;

    /**
     * Validate driver config array data
     *
     * @param array $config
     * @return bool
     */
    public static function isValidConfigArray(array $config): bool;
}
