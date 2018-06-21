<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Presenter;

use Application\Domain\Model\CpfBlacklistEventInterface;

/**
 * Cpf Blacklist Event Presenter
 *
 * @package Application\Domain\Presenter
 */
class CpfBlacklistEventPresenter implements ApiPresenterInterface
{
    /**
     * @var CpfBlacklistEventInterface
     */
    private $cpfBlacklistEvent;

    /**
     * Cpf Blacklist Event Presenter constructor
     *
     * @param CpfBlacklistEventInterface $cpfBlacklistEvent
     */
    public function __construct(CpfBlacklistEventInterface $cpfBlacklistEvent)
    {
        $this->cpfBlacklistEvent = $cpfBlacklistEvent;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $createdAt = $this->cpfBlacklistEvent->getCreatedAt() instanceof \DateTime ?
            $this->cpfBlacklistEvent->getCreatedAt()->format('Y-m-d H:i:s') :
            null
        ;

        return [
            'id' => $this->cpfBlacklistEvent->getId(),
            'type' => $this->cpfBlacklistEvent->getType(),
            'number' => $this->cpfBlacklistEvent->getNumber(),
            'createdAt' => $createdAt,
        ];
    }
}
