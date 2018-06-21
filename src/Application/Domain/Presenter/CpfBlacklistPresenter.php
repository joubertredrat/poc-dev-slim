<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Presenter;

use Application\Domain\Model\CpfBlacklistInterface;

/**
 * Cpf Blacklist Presenter
 *
 * @package Application\Domain\Presenter
 */
class CpfBlacklistPresenter implements ApiPresenterInterface
{
    /**
     * @var CpfBlacklistInterface
     */
    private $cpfBlacklist;

    /**
     * Cpf Blacklist Presenter constructor
     *
     * @param CpfBlacklistInterface $cpfBlacklist
     */
    public function __construct(CpfBlacklistInterface $cpfBlacklist)
    {
        $this->cpfBlacklist = $cpfBlacklist;
    }

    /**
     * @return CpfBlacklistInterface
     */
    public function getCpfBlacklist(): CpfBlacklistInterface
    {
        return $this->cpfBlacklist;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $createdAt = $this->cpfBlacklist->getCreatedAt() instanceof \DateTime ?
            $this->cpfBlacklist->getCreatedAt()->format('Y-m-d H:i:s') :
            null
        ;

        $updatedAt = $this->cpfBlacklist->getUpdatedAt() instanceof \DateTime ?
            $this->cpfBlacklist->getUpdatedAt()->format('Y-m-d H:i:s') :
            null
        ;

        return [
            'id' => $this->cpfBlacklist->getId(),
            'number' => $this->cpfBlacklist->getNumber(),
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt,
        ];
    }
}
