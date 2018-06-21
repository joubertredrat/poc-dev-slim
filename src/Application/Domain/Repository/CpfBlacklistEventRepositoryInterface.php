<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Repository;

use Application\Domain\Model\CpfBlacklistEventInterface;

/**
 * Cpf Blacklist Event Repository Interface
 *
 * @package Application\Domain\Repository
 */
interface CpfBlacklistEventRepositoryInterface
{
    /**
     * @param CpfBlacklistEventInterface $cpfBlacklistEvent
     * @return CpfBlacklistEventInterface
     */
    public function add(
        CpfBlacklistEventInterface $cpfBlacklistEvent
    ): CpfBlacklistEventInterface;

    /**
     * @param int $id
     * @return CpfBlacklistEventInterface|null
     */
    public function get(int $id): ?CpfBlacklistEventInterface;

    /**
     * @param string|null $sort
     * @param string|null $number
     * @param string|null $type
     * @return array<CpfBlacklistEventInterface>
     */
    public function list(
        ?string $sort = null,
        ?string $number = null,
        ?string $type = null
    ): array;

    /**
     * @return array
     */
    public function countByEvents(): array;
}
