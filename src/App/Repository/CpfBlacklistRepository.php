<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Repository;

use Application\Domain\Model\CpfBlacklist;
use Application\Domain\Model\CpfBlacklistInterface;
use Application\Domain\Repository\CpfBlacklistRepositoryInterface;

/**
 * Cpf Blacklist Repository
 *
 * @package App\Repository
 */
class CpfBlacklistRepository extends AbstractRepository implements CpfBlacklistRepositoryInterface
{
    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function add(CpfBlacklistInterface $cpfBlacklist): CpfBlacklistInterface
    {
        if (is_null($cpfBlacklist->getId())) {
            $pdo = $this
                ->getConnection()
                ->getPdo()
            ;

            $cpfBlacklist->setCreatedAt(
                new \DateTime('now')
            );

            $query = "INSERT INTO cpf_blacklist (number, created_at) "
                . "VALUES (:number, :createdAt)"
            ;

            $statement = $pdo->prepare($query);
            $statement->bindParam(
                ":number",
                $cpfBlacklist->getNumber(),
                \PDO::PARAM_STR
            );
            $statement->bindParam(
                ":createdAt",
                $cpfBlacklist->getCreatedAt()->format('Y-m-d H:i:s'),
                \PDO::PARAM_STR
            );

            $statement->execute();

            $this->bindIdModel($cpfBlacklist, $pdo->lastInsertId());
        }

        return $cpfBlacklist;
    }

    /**
     * {@inheritdoc}
     */
    public function update(CpfBlacklistInterface $cpfBlacklist): CpfBlacklistInterface
    {
        if (!is_null($cpfBlacklist->getId())) {
            $pdo = $this
                ->getConnection()
                ->getPdo()
            ;

            $cpfBlacklist->setUpdatedAt(
                new \DateTime('now')
            );

            $query = "UPDATE cpf_blacklist set number = :number, updated_at = :updatedAt "
                . "WHERE id = :id"
            ;

            $statement = $pdo->prepare($query);
            $statement->bindParam(
                ":number",
                $cpfBlacklist->getNumber(),
                \PDO::PARAM_STR
            );
            $statement->bindParam(
                ":updated",
                $cpfBlacklist->getUpdatedAt()->format('Y-m-d H:i:s'),
                \PDO::PARAM_STR
            );
            $statement->bindParam(
                ":id",
                $cpfBlacklist->getId(),
                \PDO::PARAM_INT
            );

            $statement->execute();
        }

        return $cpfBlacklist;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(CpfBlacklistInterface $cpfBlacklist): bool
    {
        if (!is_null($cpfBlacklist->getId())) {
            $pdo = $this
                ->getConnection()
                ->getPdo()
            ;

            $query = "DELETE FROM cpf_blacklist WHERE id = :id";
            $statement = $pdo->prepare($query);
            $statement->bindParam(
                ":id",
                $cpfBlacklist->getId(),
                \PDO::PARAM_INT
            );

            $statement->execute();
        }

        return true;
    }

    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function get(int $id): ?CpfBlacklistInterface
    {
        $pdo = $this
            ->getConnection()
            ->getPdo()
        ;

        $query = "SELECT * FROM cpf_blacklist WHERE id = :id";
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
            $cpfBlacklist = new CpfBlacklist();
            $this->bindDataModel($cpfBlacklist, $data[0]);

            return $cpfBlacklist;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function getByNumber(string $number): ?CpfBlacklistInterface
    {
        $pdo = $this
            ->getConnection()
            ->getPdo()
        ;

        $query = "SELECT * FROM cpf_blacklist WHERE number = :number";
        $statement = $pdo->prepare($query);
        $statement->bindParam(
            ":number",
            $number,
            \PDO::PARAM_STR
        );

        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $statement->execute();
        $data = $statement->fetchAll();

        if (count($data) == 1) {
            $cpfBlacklist = new CpfBlacklist();
            $this->bindDataModel($cpfBlacklist, $data[0]);

            return $cpfBlacklist;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function list(): array
    {
        $return = [];

        $pdo = $this
            ->getConnection()
            ->getPdo()
        ;

        $query = "SELECT * FROM cpf_blacklist";
        $statement = $pdo->prepare($query);

        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $statement->execute();
        $data = $statement->fetchAll();

        if (count($data) > 0) {
            foreach ($data as $row) {
                $cpfBlacklist = new CpfBlacklist();
                $this->bindDataModel($cpfBlacklist, $row);

                $return[] = $cpfBlacklist;
            }
        }

        return $return;
    }

    /**
     * {@inheritdoc}
     */
    public function countBlacklist(): int
    {
        $pdo = $this
            ->getConnection()
            ->getPdo()
        ;

        $query = "SELECT COUNT(*) AS total FROM cpf_blacklist";
        $statement = $pdo->prepare($query);

        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $statement->execute();
        $data = $statement->fetchAll();

        return (int) $data[0]['total'];
    }

    /**
     * @param CpfBlacklistInterface $cpfBlacklist
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    public function bindDataModel(CpfBlacklistInterface $cpfBlacklist, array $data): void
    {
        $this->bindIdModel($cpfBlacklist, (int) $data['id']);

        $cpfBlacklist->setNumber($data['number']);
        $cpfBlacklist->setCreatedAt(
            new \DateTime($data['created_at'])
        );

        if ($data['updated_at']) {
            $cpfBlacklist->setUpdatedAt(
                new \DateTime($data['updated_at'])
            );
        }
    }
}
