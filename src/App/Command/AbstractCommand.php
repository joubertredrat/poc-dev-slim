<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Command;

use Psr\Container\ContainerInterface;

/**
 * Abstract Command
 *
 * @package App\Command
 */
abstract class AbstractCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Database Create Command constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
