<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Model;

/**
 * Cpf Blacklist Event Interface
 *
 * @package Application\Domain\Model
 */
interface CpfBlacklistEventInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return string|null
     */
    public function getType(): ?string;

    /**
     * @param string $type
     * @return void
     */
    public function setType(string $type): void;

    /**
     * @return string|null
     */
    public function getNumber(): ?string;

    /**
     * @param string|null $number
     * @return void
     */
    public function setNumber(?string $number): void;

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime;

    /**
     * @param \DateTime $createdAt
     * @return void
     */
    public function setCreatedAt(\DateTime $createdAt): void;

    /**
     * @return array
     */
    public static function getEventTypesAvailable(): array;

    /**
     * @param string|null $type
     * @return bool
     */
    public static function isValidEventType(?string $type): bool;
}
