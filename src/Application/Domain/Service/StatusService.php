<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Service;

use Application\Domain\Component\Status;

/**
 * Status Service
 *
 * @package Application\Domain\Service
 */
class StatusService
{
    const UPTIME_CMD = '/usr/bin/uptime';

    /**
     * @var CpfBlacklistService
     */
    private $cpfBlacklistService;

    /**
     * @var CpfBlacklistEventService
     */
    private $cpfBlacklistEventService;

    /**
     * StatusService constructor.
     * @param CpfBlacklistService $cpfBlacklistService
     * @param CpfBlacklistEventService $cpfBlacklistEventService
     */
    public function __construct(
        CpfBlacklistService $cpfBlacklistService,
        CpfBlacklistEventService $cpfBlacklistEventService
    ) {
        $this->cpfBlacklistService = $cpfBlacklistService;
        $this->cpfBlacklistEventService = $cpfBlacklistEventService;
    }

    /**
     * @return Status
     * @throws \ReflectionException
     */
    public function getStatus(): Status
    {
        $status = new Status();
        $status->setUptime(
            $this->getUptime()
        );

        $status->setEventsCount(
            $this->getEventsCount()
        );

        $status->setCpfBlacklistCount(
            $this->getCpfBlacklistCount()
        );

        return $status;
    }

    /**
     * @return string
     */
    public function getUptime(): string
    {
        return shell_exec(self::UPTIME_CMD);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getEventsCount(): array
    {
        return $this
            ->cpfBlacklistEventService
            ->getEventsCount()
        ;
    }

    /**
     * @return int
     */
    public function getCpfBlacklistCount(): int
    {
        return $this
            ->cpfBlacklistService
            ->getCpfBlacklistCount()
        ;
    }
}
