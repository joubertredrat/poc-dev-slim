<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Presenter;

/**
 * Api List Presenter
 *
 * @package Application\Domain\Presenter
 */
class ApiListPresenter implements ApiListPresenterInterface
{
    use ListPresenterTrait;

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $return = [];

        /** @var ApiPresenterInterface $presenter */
        foreach ($this->getPresenters() as $presenter) {
            $return[] = $presenter->toArray();
        }

        return $return;
    }
}
