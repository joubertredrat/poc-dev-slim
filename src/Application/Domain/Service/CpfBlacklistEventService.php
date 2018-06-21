<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Service;

use Application\Domain\Exception\Cpf\Blacklist\Event\InvalidSortException as CpfBlacklistEventInvalidSortException;
use Application\Domain\Exception\Cpf\Blacklist\Event\InvalidTypeException as CpfBlacklistEventInvalidTypeException;
use Application\Domain\Model\CpfBlacklistEvent;
use Application\Domain\Model\CpfBlacklistEventInterface;
use Application\Domain\Model\CpfBlacklistInterface;
use Application\Domain\Presenter\ApiListPresenter;
use Application\Domain\Presenter\ApiPresenterInterface;
use Application\Domain\Presenter\CpfBlacklistEventPresenter;
use Application\Domain\Repository\CpfBlacklistEventRepositoryInterface;

/**
 * Cpf Blacklist Event Service
 *
 * @package Application\Domain\Service
 */
class CpfBlacklistEventService
{
    /**
     * Sort available
     */
    const SORT_OLDER = 'older';
    const SORT_NEWER = 'newer';

    /**
     * @var CpfBlacklistEventRepositoryInterface
     */
    private $cpfBlacklistEventRepository;

    /**
     * Cpf Blacklist Event Service constructor
     *
     * @param CpfBlacklistEventRepositoryInterface $cpfBlacklistEventRepository
     */
    public function __construct(
        CpfBlacklistEventRepositoryInterface $cpfBlacklistEventRepository
    ) {
        $this->cpfBlacklistEventRepository = $cpfBlacklistEventRepository;
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function registerEventList(): void
    {
        $this->registerEvent(CpfBlacklistEvent::EVENT_TYPE_LIST);
    }

    /**
     * @param CpfBlacklistInterface $cpfBlacklist
     * @return void
     * @throws \ReflectionException
     */
    public function registerEventConsult(CpfBlacklistInterface $cpfBlacklist): void
    {
        $this->registerEvent(
            CpfBlacklistEvent::EVENT_TYPE_CONSULT,
            $cpfBlacklist->getNumber()
        );
    }

    /**
     * @param CpfBlacklistInterface $cpfBlacklist
     * @return void
     * @throws \ReflectionException
     */
    public function registerEventGet(CpfBlacklistInterface $cpfBlacklist): void
    {
        $this->registerEvent(
            CpfBlacklistEvent::EVENT_TYPE_GET,
            $cpfBlacklist->getNumber()
        );
    }

    /**
     * @param CpfBlacklistInterface $cpfBlacklist
     * @return void
     * @throws \ReflectionException
     */
    public function registerEventAdd(CpfBlacklistInterface $cpfBlacklist): void
    {
        $this->registerEvent(
            CpfBlacklistEvent::EVENT_TYPE_ADD,
            $cpfBlacklist->getNumber()
        );
    }

    /**
     * @param CpfBlacklistInterface $cpfBlacklist
     * @return void
     * @throws \ReflectionException
     */
    public function registerEventDelete(CpfBlacklistInterface $cpfBlacklist): void
    {
        $this->registerEvent(
            CpfBlacklistEvent::EVENT_TYPE_DELETE,
            $cpfBlacklist->getNumber()
        );
    }

    /**
     * @param string $type
     * @param string|null $number
     * @throws \ReflectionException
     */
    public function registerEvent(string $type, ?string $number = null): void
    {
        $cpfBlacklistEvent = new CpfBlacklistEvent($type);

        if ($number) {
            $cpfBlacklistEvent->setNumber($number);
        }

        $this->add($cpfBlacklistEvent);
    }

    /**
     * @param CpfBlacklistEventInterface $cpfBlacklistEvent
     * @return CpfBlacklistEventInterface
     */
    public function add(
        CpfBlacklistEventInterface $cpfBlacklistEvent
    ): CpfBlacklistEventInterface {
        return $this
            ->cpfBlacklistEventRepository
            ->add($cpfBlacklistEvent)
        ;
    }

    /**
     * @param string|null $sort
     * @param string|null $number
     * @param string|null $type
     * @return array<CpfBlacklistEventInterface>
     * @throws CpfBlacklistEventInvalidSortException
     * @throws CpfBlacklistEventInvalidTypeException
     * @throws \ReflectionException
     */
    public function listEvents(
        ?string $sort = null,
        ?string $number = null,
        ?string $type = null
    ): array {
        if (!self::isValidSort($sort)) {
            throw new CpfBlacklistEventInvalidSortException(
                sprintf('Invalid event sort %s', $sort)
            );
        }

        if (!is_null($type) && !CpfBlacklistEvent::isValidEventType($type)) {
            throw new CpfBlacklistEventInvalidTypeException(
                sprintf('Invalid event type %s', $type)
            );
        }

        return $this
            ->cpfBlacklistEventRepository
            ->list(
                self::convertSort($sort),
                $number,
                $type
            )
        ;
    }

    /**
     * @param string|null $sort
     * @param string|null $number
     * @param string|null $type
     * @return ApiPresenterInterface
     * @throws CpfBlacklistEventInvalidSortException
     * @throws CpfBlacklistEventInvalidTypeException
     * @throws \ReflectionException
     */
    public function listEventsApi(
        ?string $sort = null,
        ?string $number = null,
        ?string $type = null
    ): ApiPresenterInterface {
        $apiListPresenter = new ApiListPresenter();

        $cpfBlacklistEventList = $this->listEvents($sort, $number, $type);

        foreach ($cpfBlacklistEventList as $cpfBlacklistEvent) {
            $apiListPresenter->addPresenter(
                new CpfBlacklistEventPresenter($cpfBlacklistEvent)
            );
        }

        return $apiListPresenter;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getEventsCount(): array
    {
        $return = [];

        foreach (CpfBlacklistEvent::getEventTypesAvailable() as $type) {
            $return[$type] = 0;
        }

        $data = $this
            ->cpfBlacklistEventRepository
            ->countByEvents()
        ;

        foreach ($data as $row) {
            $return[$row["type"]] = (int) $row["total"];
        }

        return $return;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public static function getSortAvailable(): array
    {
        $reflection = new \ReflectionClass(self::class);

        return array_values($reflection->getConstants());
    }

    /**
     * @param string|null $sort
     * @return bool
     * @throws \ReflectionException
     */
    public static function isValidSort(?string $sort): bool
    {
        if (is_null($sort)) {
            return true;
        }

        return in_array($sort, self::getSortAvailable());
    }

    /**
     * @param string|null $sort
     * @return string|null
     */
    private function convertSort(?string $sort): ?string
    {
        switch ($sort) {
            case self::SORT_NEWER:
                return 'desc';
                break;
            case self::SORT_OLDER:
                return 'asc';
                break;
            default:
                return null;
                break;
        }
    }
}
