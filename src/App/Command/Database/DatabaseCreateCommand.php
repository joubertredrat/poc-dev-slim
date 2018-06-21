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
 * Database Create Command
 *
 * @package App\Command\Database
 */
class DatabaseCreateCommand extends AbstractCommand implements CommandInterface
{
    /**
     * {@inheritdoc}
     */
    public function command(array $args): string
    {
        $settings = $this->container->get('settings')['database'];

        if (!file_exists($settings['filePath'])) {
            touch($settings['filePath']);
        }

        return "Database created" . PHP_EOL;
    }
}
