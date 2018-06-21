<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace Application\Domain\Service;

use Application\Domain\Exception\Cpf\Blacklist\HasExistException as CpfBlacklistHasExistException;
use Application\Domain\Exception\Cpf\Blacklist\NotFoundException as CpfBlacklistNotFoundException;
use Application\Domain\Exception\Cpf\InvalidNumberException as CpfInvalidNumberException;
use Application\Domain\Model\CpfBlacklist;
use Application\Domain\Model\CpfBlacklistInterface;
use Application\Domain\Presenter\ApiListPresenter;
use Application\Domain\Presenter\ApiListPresenterInterface;
use Application\Domain\Presenter\ApiPresenterInterface;
use Application\Domain\Presenter\CpfBlacklistPresenter;
use Application\Domain\Repository\CpfBlacklistRepositoryInterface;

/**
 * Cpf Blacklist Service
 *
 * @package Application\Domain\Service
 */
class CpfBlacklistService
{
    /**
     * @var CpfBlacklistRepositoryInterface
     */
    private $cpfBlacklistRepository;

    /**
     * Cpf Blacklist Service constructor
     *
     * @param CpfBlacklistRepositoryInterface $cpfBlacklistRepository
     */
    public function __construct(
        CpfBlacklistRepositoryInterface $cpfBlacklistRepository
    ) {
        $this->cpfBlacklistRepository = $cpfBlacklistRepository;
    }

    /**
     * @return array<CpfBlacklistInterface>
     */
    public function listCpf(): array
    {
        return $this
            ->cpfBlacklistRepository
            ->list()
        ;
    }

    /**
     * @return ApiListPresenterInterface
     */
    public function listCpfApi(): ApiListPresenterInterface
    {
        $apiListPresenter = new ApiListPresenter();

        /** @var CpfBlacklistInterface $cpfBlacklist */
        foreach ($this->listCpf() as $cpfBlacklist) {
            $apiListPresenter->addPresenter(
                new CpfBlacklistPresenter($cpfBlacklist)
            );
        }

        return $apiListPresenter;
    }

    /**
     * @param int $id
     * @return CpfBlacklistInterface
     * @throws CpfBlacklistNotFoundException
     */
    public function getCpf(int $id): CpfBlacklistInterface
    {
        $cpfBlacklist = $this
            ->cpfBlacklistRepository
            ->get($id)
        ;

        if (!$cpfBlacklist instanceof CpfBlacklistInterface) {
            throw new CpfBlacklistNotFoundException(
                sprintf('Cpf with id %d not found', $id)
            );
        }

        return $cpfBlacklist;
    }

    /**
     * @param int $id
     * @return ApiPresenterInterface
     * @throws CpfBlacklistNotFoundException
     */
    public function getCpfApi(int $id): ApiPresenterInterface
    {
        $cpfBlacklist = $this->getCpf($id);

        return new CpfBlacklistPresenter($cpfBlacklist);
    }

    /**
     * @param string $number
     * @return CpfBlacklistInterface
     * @throws CpfInvalidNumberException
     * @throws CpfBlacklistNotFoundException
     */
    public function getCpfByNumber(string $number): CpfBlacklistInterface
    {
        if (!CpfBlacklist::isValid($number)) {
            throw new CpfInvalidNumberException(
                sprintf('Cpf with invalid number %s', $number)
            );
        }

        $cpfBlacklistFound = $this
            ->cpfBlacklistRepository
            ->getByNumber($number)
        ;

        if (!$cpfBlacklistFound instanceof CpfBlacklistInterface) {
            throw new CpfBlacklistNotFoundException(
                sprintf('Cpf with number %s not found', $number)
            );
        }

        return $cpfBlacklistFound;
    }

    /**
     * @param string $number
     * @return ApiPresenterInterface
     * @throws CpfInvalidNumberException
     * @throws CpfBlacklistNotFoundException
     */
    public function getCpfByNumberApi(string $number): ApiPresenterInterface
    {
        $cpfBlacklist = $this->getCpfByNumber($number);

        return new CpfBlacklistPresenter($cpfBlacklist);
    }

    /**
     * @param string $number
     * @return CpfBlacklistInterface
     * @throws CpfInvalidNumberException
     * @throws CpfBlacklistHasExistException
     */
    public function addCpf(string $number): CpfBlacklistInterface
    {
        if (!CpfBlacklist::isValid($number)) {
            throw new CpfInvalidNumberException(
                sprintf('Cpf with invalid number %s', $number)
            );
        }

        $cpfBlacklistFound = $this
            ->cpfBlacklistRepository
            ->getByNumber($number)
        ;

        if ($cpfBlacklistFound instanceof CpfBlacklistInterface) {
            throw new CpfBlacklistHasExistException(
                sprintf('Cpf with number %s already exists on database', $number)
            );
        }

        $cpfBlacklist = new CpfBlacklist();
        $cpfBlacklist->setNumber($number);

        return $this
            ->cpfBlacklistRepository
            ->add($cpfBlacklist)
        ;
    }

    /**
     * @param string $number
     * @return ApiPresenterInterface
     * @throws CpfInvalidNumberException
     * @throws CpfBlacklistHasExistException
     */
    public function addCpfApi(string $number): ApiPresenterInterface
    {
        $cpfBlacklist = $this->addCpf($number);

        return new CpfBlacklistPresenter($cpfBlacklist);
    }

    /**
     * @param int $id
     * @return CpfBlacklistInterface
     * @throws CpfBlacklistNotFoundException
     */
    public function deleteCpf(int $id): CpfBlacklistInterface
    {
        $cpfBlacklist = $this->getCpf($id);

        $this
            ->cpfBlacklistRepository
            ->delete($cpfBlacklist)
        ;

        return $cpfBlacklist;
    }

    /**
     * @return int
     */
    public function getCpfBlacklistCount(): int
    {
        return $this
            ->cpfBlacklistRepository
            ->countBlacklist()
        ;
    }
}
