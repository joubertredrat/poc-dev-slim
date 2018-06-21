<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Repository;

use Application\Domain\Model\CpfBlacklistInterface;

/**
 * Cpf Blacklist Repository Interface
 *
 * @package Application\Domain\Repository
 */
interface CpfBlacklistRepositoryInterface
{
    /**
     * @param CpfBlacklistInterface $cpfBlacklist
     * @return CpfBlacklistInterface
     */
    public function add(CpfBlacklistInterface $cpfBlacklist): CpfBlacklistInterface;

    /**
     * @param CpfBlacklistInterface $cpfBlacklist
     * @return CpfBlacklistInterface
     */
    public function update(CpfBlacklistInterface $cpfBlacklist): CpfBlacklistInterface;

    /**
     * @param CpfBlacklistInterface $cpfBlacklist
     * @return bool
     */
    public function delete(CpfBlacklistInterface $cpfBlacklist): bool;

    /**
     * @param int $id
     * @return CpfBlacklistInterface|null
     */
    public function get(int $id): ?CpfBlacklistInterface;

    /**
     * @param string $number
     * @return CpfBlacklistInterface|null
     */
    public function getByNumber(string $number): ?CpfBlacklistInterface;

    /**
     * @return array<CpfBlacklistInterface>
     */
    public function list(): array;

    /**
     * @return int
     */
    public function countBlacklist(): int;
}
