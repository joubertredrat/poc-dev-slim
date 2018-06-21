<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Presenter;

/**
 * Api List Presenter Interface
 *
 * @package Application\Domain\Presenter
 */
interface ApiListPresenterInterface extends ApiPresenterInterface
{
    /**
     * @param ApiPresenterInterface $presenter
     * @return void
     */
    public function addPresenter(ApiPresenterInterface $presenter): void;

    /**
     * @param ApiPresenterInterface $presenter
     * @return bool
     */
    public function hasPresenter(ApiPresenterInterface $presenter): bool;

    /**
     * @param ApiPresenterInterface $presenter
     * @return void
     */
    public function deletePresenter(ApiPresenterInterface $presenter): void;

    /**
     * @return array<ApiPresenterInterface>
     */
    public function getPresenters(): array;
}
