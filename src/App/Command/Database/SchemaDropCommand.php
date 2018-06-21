<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Command\Database;

use App\Command\AbstractCommand;
use App\Command\CommandInterface;

/**
 * Schema Drop Command
 *
 * @package App\Command\Database
 */
class SchemaDropCommand extends AbstractCommand implements CommandInterface
{
    /**
     * {@inheritdoc}
     */
    public function command(array $args): string
    {
        $connection = $this->container->get('db.sqlite');

        /** @var \PDO $pdo */
        $pdo = $connection->getPdo();

        $pdo->query('DROP TABLE `cpf_blacklist`');
        $pdo->query('DROP TABLE `cpf_blacklist_event`');

        return "Schema droped" . PHP_EOL;
    }
}
