<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Repository;

use Application\Domain\Model\CpfBlacklistEvent;
use Application\Domain\Model\CpfBlacklistEventInterface;
use Application\Domain\Repository\CpfBlacklistEventRepositoryInterface;

/**
 * Cpf Blacklist Event Repository
 * @package App\Repository
 */
class CpfBlacklistEventRepository extends AbstractRepository implements
    CpfBlacklistEventRepositoryInterface
{
    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function add(
        CpfBlacklistEventInterface $cpfBlacklistEvent
    ): CpfBlacklistEventInterface {
        if (is_null($cpfBlacklistEvent->getId())) {
            $pdo = $this
                ->getConnection()
                ->getPdo()
            ;

            $cpfBlacklistEvent->setCreatedAt(
                new \DateTime('now')
            );

            $query = "INSERT INTO cpf_blacklist_event (type, number, created_at) "
                . "VALUES (:type, :number, :createdAt)"
            ;

            $statement = $pdo->prepare($query);

            $statement->bindParam(
                ":type",
                $cpfBlacklistEvent->getType(),
                \PDO::PARAM_STR
            );

            $number = $cpfBlacklistEvent->getNumber() ?? null;

            $statement->bindParam(
                ":number",
                $number,
                \PDO::PARAM_STR
            );
            $statement->bindParam(
                ":createdAt",
                $cpfBlacklistEvent->getCreatedAt()->format('Y-m-d H:i:s'),
                \PDO::PARAM_STR
            );

            $statement->execute();

            $this->bindIdModel($cpfBlacklistEvent, $pdo->lastInsertId());
        }

        return $cpfBlacklistEvent;
    }

    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function get(int $id): ?CpfBlacklistEventInterface
    {
        $pdo = $this
            ->getConnection()
            ->getPdo()
        ;

        $query = "SELECT * FROM cpf_blacklist_event WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(
            ":id",
            $id,
            \PDO::PARAM_INT
        );

        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $statement->execute();
        $data = $statement->fetchAll();

        if (count($data) == 1) {
            $cpfBlacklistEvent = new CpfBlacklistEvent();
            $this->bindDataModel($cpfBlacklistEvent, $data[0]);

            return $cpfBlacklistEvent;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function list(
        ?string $sort = null,
        ?string $number = null,
        ?string $type = null
    ): array {
        $return = [];

        $pdo = $this
            ->getConnection()
            ->getPdo()
        ;

        $where = [];
        if ($type) {
            $where[] = "type = :type";
        }

        if ($number) {
            $where[] = "number = :number";
        }

        $query = "SELECT * FROM cpf_blacklist_event";

        if ($where) {
            $query .= " WHERE " . implode("AND", $where);
        }

        if ($sort) {
            $query .= " ORDER BY id " . $sort;
        }

        $statement = $pdo->prepare($query);

        if ($type) {
            $statement->bindParam(
                ":type",
                $type,
                \PDO::PARAM_STR
            );
        }

        if ($number) {
            $statement->bindParam(
                ":number",
                $number,
                \PDO::PARAM_STR
            );
        }

        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $statement->execute();
        $data = $statement->fetchAll();

        if (count($data) > 0) {
            foreach ($data as $row) {
                $cpfBlacklistEvent = new CpfBlacklistEvent();
                $this->bindDataModel($cpfBlacklistEvent, $row);

                $return[] = $cpfBlacklistEvent;
            }
        }

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function countByEvents(): array
    {
        $pdo = $this
            ->getConnection()
            ->getPdo()
        ;

        $query = "SELECT type, COUNT(*) AS total FROM cpf_blacklist_event "
            . "GROUP BY type"
        ;
        $statement = $pdo->prepare($query);

        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $statement->execute();
        return $statement->fetchAll();
    }

    /**
     * @param CpfBlacklistEventInterface $cpfBlacklistEvent
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    public function bindDataModel(
        CpfBlacklistEventInterface $cpfBlacklistEvent,
        array $data
    ): void {
        $this->bindIdModel($cpfBlacklistEvent, (int) $data['id']);

        $cpfBlacklistEvent->setType($data['type']);
        $cpfBlacklistEvent->setNumber($data['number']);
        $cpfBlacklistEvent->setCreatedAt(
            new \DateTime($data['created_at'])
        );
    }
}
