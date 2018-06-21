<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Repository;

use App\Component\Database\Connection;

/**
 * Repository Interface
 *
 * @package App\Repository
 */
interface RepositoryInterface
{
    /**
     * @return Connection
     */
    public function getConnection(): Connection;
}
