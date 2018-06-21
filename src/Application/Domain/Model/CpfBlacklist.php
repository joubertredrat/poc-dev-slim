<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Model;

/**
 * Cpf Blacklist
 *
 * @package Application\Domain\Model
 */
class CpfBlacklist implements CpfBlacklistInterface
{
    use CpfTrait;
    use DateTimeTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
