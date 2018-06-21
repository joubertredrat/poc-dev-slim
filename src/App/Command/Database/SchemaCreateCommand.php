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
 * Schema Create Command
 *
 * @package App\Command\Database
 */
class SchemaCreateCommand extends AbstractCommand implements CommandInterface
{
    /**
     * {@inheritdoc}
     */
    public function command(array $args): string
    {
        $connection = $this->container->get('db.sqlite');

        /** @var \PDO $pdo */
        $pdo = $connection->getPdo();

        $cpfBlacklistFields = [
            '`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT',
            '`number` VARCHAR(11) NOT NULL',
            '`created_at` DATETIME NOT NULL',
            '`updated_at` DATETIME DEFAULT NULL',
        ];

        $queryCpfBlacklist = 'CREATE TABLE `cpf_blacklist` (' . implode(', ', $cpfBlacklistFields) . ')';
        $pdo->query($queryCpfBlacklist);

        $cpfBlacklistEventFields = [
            '`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT',
            '`type` VARCHAR(20) NOT NULL COLLATE BINARY',
            '`number` VARCHAR(11) NOT NULL',
            '`created_at` DATETIME NOT NULL',
        ];

        $queryCpfBlacklist = 'CREATE TABLE `cpf_blacklist_event` (' . implode(', ', $cpfBlacklistEventFields) . ')';
        $pdo->query($queryCpfBlacklist);

        return "Schema created" . PHP_EOL;
    }
}
