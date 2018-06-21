<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Presenter;

/**
 * List Presenter Trait
 *
 * @package Application\Domain\Presenter
 */
trait ListPresenterTrait
{
    /**
     * @var array
     */
    protected $presenter = [];

    /**
     * {@inheritdoc}
     */
    public function addPresenter(ApiPresenterInterface $presenter): void
    {
        if (!$this->hasPresenter($presenter)) {
            $this->presenter[] = $presenter;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasPresenter(ApiPresenterInterface $presenter): bool
    {
        return in_array($presenter, $this->presenter);
    }

    /**
     * {@inheritdoc}
     */
    public function deletePresenter(ApiPresenterInterface $presenter): void
    {
        if ($this->hasPresenter($presenter)) {
            $this->presenter = array_diff($this->presenter, [$presenter]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPresenters(): array
    {
        return $this->presenter;
    }
}
