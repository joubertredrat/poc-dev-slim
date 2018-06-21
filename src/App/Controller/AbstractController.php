<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Controller;

use Psr\Container\ContainerInterface;

/**
 * Abstract Controller
 *
 * @package App\Controller
 */
abstract class AbstractController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Cpf Blacklist Controller constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $name
     * @return object
     */
    public function getService(string $name)
    {
        return $this->container->get($name);
    }
}
