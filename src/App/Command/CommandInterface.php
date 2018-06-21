<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Command;

/**
 * Command Interface
 * @package App\Command
 *
 */
interface CommandInterface
{
    /**
     * @param array $args
     * @return string
     */
    public function command(array $args): string;
}
