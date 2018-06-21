<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Component;

/**
 * Status
 *
 * @package Application\Domain\Component
 */
class Status
{
    /**
     * @var string
     */
    private $uptime;

    /**
     * @var array
     */
    private $eventsCount;

    /**
     * @var int
     */
    private $cpfBlacklistCount;

    /**
     * Status constructor
     */
    public function __construct()
    {
        $this->eventsCount = [];
        $this->cpfBlacklistCount = 0;
    }

    /**
     * @return string|null
     */
    public function getUptime(): ?string
    {
        return $this->uptime;
    }

    /**
     * @param string $uptime
     * @retun void
     */
    public function setUptime(string $uptime): void
    {
        $this->uptime = $uptime;
    }

    /**
     * @return array
     */
    public function getEventsCount(): array
    {
        return $this->eventsCount;
    }

    /**
     * @param array $eventsCount
     */
    public function setEventsCount(array $eventsCount): void
    {
        $this->eventsCount = $eventsCount;
    }

    /**
     * @return int
     */
    public function getCpfBlacklistCount(): int
    {
        return $this->cpfBlacklistCount;
    }

    /**
     * @param int $cpfBlacklistCount
     */
    public function setCpfBlacklistCount(int $cpfBlacklistCount): void
    {
        $this->cpfBlacklistCount = $cpfBlacklistCount;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uptime' => $this->getUptime(),
            'cpfBlacklistCount' => $this->getCpfBlacklistCount(),
            'eventsCount' => $this->getEventsCount(),
        ];
    }
}
