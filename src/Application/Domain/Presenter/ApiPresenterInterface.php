<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Presenter;

/**
 * Api Presenter Interface
 *
 * @package Application\Domain\Presenter
 */
interface ApiPresenterInterface
{
    /**
     * Format Model data to array for API output
     *
     * @return array
     */
    public function toArray(): array;
}
