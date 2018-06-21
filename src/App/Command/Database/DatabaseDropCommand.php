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
 * Database Drop Command
 *
 * @package App\Command\Database
 */
class DatabaseDropCommand extends AbstractCommand implements CommandInterface
{
    /**
     * {@inheritdoc}
     */
    public function command(array $args): string
    {
        $settings = $this->container->get('settings')['database'];

        if (file_exists($settings['filePath'])) {
            unlink($settings['filePath']);
        }

        return "Database droped" . PHP_EOL;
    }
}
