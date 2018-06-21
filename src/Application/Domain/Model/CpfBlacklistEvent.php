<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Model;

/**
 * Cpf Blacklist Event
 *
 * @package Application\Domain\Model
 */
class CpfBlacklistEvent implements CpfBlacklistEventInterface
{
    use CpfTrait;
    use DateTimeTrait;

    /**
     * Available events
     */
    const EVENT_TYPE_CONSULT = 'consult';
    const EVENT_TYPE_LIST = 'list';
    const EVENT_TYPE_GET = 'get';
    const EVENT_TYPE_ADD = 'add';
    const EVENT_TYPE_DELETE = 'delete';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * Cpf Blacklist Event constructor
     *
     * @param string|null $type
     * @throws \ReflectionException
     */
    public function __construct(?string $type = null)
    {
        if ($type) {
            $this->setType($type);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function setType(string $type): void
    {
        if (self::isValidEventType($type)) {
            $this->type = $type;
        }
    }

    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public static function getEventTypesAvailable(): array
    {
        $reflection = new \ReflectionClass(self::class);

        return array_values($reflection->getConstants());
    }

    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public static function isValidEventType(?string $type): bool
    {
        return in_array($type, self::getEventTypesAvailable());
    }

    /**
     * @return CpfBlacklistEvent
     * @throws \ReflectionException
     */
    public static function newConsult(): self
    {
        return new self(self::EVENT_TYPE_CONSULT);
    }

    /**
     * @return CpfBlacklistEvent
     * @throws \ReflectionException
     */
    public static function newList(): self
    {
        return new self(self::EVENT_TYPE_LIST);
    }

    /**
     * @return CpfBlacklistEvent
     * @throws \ReflectionException
     */
    public static function newGet(): self
    {
        return new self(self::EVENT_TYPE_GET);
    }

    /**
     * @return CpfBlacklistEvent
     * @throws \ReflectionException
     */
    public static function newAdd(): self
    {
        return new self(self::EVENT_TYPE_ADD);
    }

    /**
     * @return CpfBlacklistEvent
     * @throws \ReflectionException
     */
    public static function newDelete(): self
    {
        return new self(self::EVENT_TYPE_DELETE);
    }
}
