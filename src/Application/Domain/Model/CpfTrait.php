<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Model;

/**
 * Cpf Trait
 *
 * @package Application\Domain\Model
 */
trait CpfTrait
{
    /**
     * @var string
     */
    private $number;

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string|null $number
     */
    public function setNumber(?string $number): void
    {
        if (self::isValid($number)) {
            $this->number = $number;
        }
    }

    /**
     * @param string|null $number
     * @return bool
     */
    public static function isValid(?string $number): bool
    {
        if (is_null($number)) {
            return false;
        }

        $number = preg_replace("/[^0-9]/", "", $number);

        if (strlen($number) != 11) {
            return false;
        }

        if (preg_match("/^(\d)\1+$/", $number)) {
            return false;
        }

        $sum = [];

        for ($i = 0, $j = 10; $i < 9; $i++, $j--) {
            $sum[] = $number{$i} * $j;
        }

        $rest = array_sum($sum) % 11;
        $digit1 = $rest < 2 ? 0 : 11 - $rest;

        if ($number{9} != $digit1) {
            return false;
        }

        $sum = [];

        for ($i = 0, $j = 11; $i < 10; $i++, $j--) {
            $sum[] = $number{$i} * $j;
        }

        $rest = array_sum($sum) % 11;
        $digit2 = $rest < 2 ? 0 : 11 - $rest;

        return $number{10} == $digit2;
    }
}
