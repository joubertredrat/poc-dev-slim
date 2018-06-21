<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Controller;

use App\Component\HttpResponse;
use Application\Domain\Exception\Cpf\Blacklist\HasExistException as CpfBlacklistHasExistException;
use Application\Domain\Exception\Cpf\Blacklist\NotFoundException as CpfBlacklistNotFoundException;
use Application\Domain\Exception\Cpf\InvalidNumberException as CpfInvalidNumberException;
use Application\Domain\Model\CpfBlacklist;
use Application\Domain\Presenter\CpfBlacklistPresenter;
use Application\Domain\Service\CpfBlacklistEventService;
use Application\Domain\Service\CpfBlacklistService;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Cpf Blacklist Controller
 *
 * @package App\Controller
 */
class CpfBlacklistController extends AbstractController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function consultAction(Request $request, Response $response): Response
    {
        try {
            $cpf = $request->getQueryParam('cpf');

            if (!CpfBlacklist::isValid($cpf)) {
                throw new CpfInvalidNumberException(
                    sprintf('Cpf with invalid number %s', $cpf)
                );
            }

            /** @var CpfBlacklistService $cpfBlacklistService */
            $cpfBlacklistService = $this->getService('app.service.cpf_blacklist');
            /** @var CpfBlacklistEventService $cpfBlacklistEventService */
            $cpfBlacklistEventService = $this->getService('app.service.cpf_blacklist_event');

            $cpfBlacklistConsult = new CpfBlacklist();
            $cpfBlacklistConsult->setNumber($cpf);
            $cpfBlacklistEventService->registerEventConsult($cpfBlacklistConsult);

            $cpfBlacklistPresenter = $cpfBlacklistService->getCpfByNumberApi(
                $cpfBlacklistConsult->getNumber()
            );

            $responseData = $cpfBlacklistPresenter->toArray();
            $statusCode = HttpResponse::OK;
        } catch (CpfInvalidNumberException $e) {
            $responseData = [
                'error' => $e->getMessage(),
            ];
            $statusCode = HttpResponse::BAD_REQUEST;
        } catch (CpfBlacklistNotFoundException $e) {
            $responseData = [
                'error' => $e->getMessage(),
            ];
            $statusCode = HttpResponse::NOT_FOUND;
        } catch (\Throwable $e) {
            $responseData = [
                'error' => $e->getMessage(),
            ];
            $statusCode = HttpResponse::INTERNAL_SERVER_ERROR;
        } finally {
            return $response->withJson($responseData, $statusCode);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function listAction(Request $request, Response $response): Response
    {
        try {
            /** @var CpfBlacklistService $cpfBlacklistService */
            $cpfBlacklistService = $this->getService('app.service.cpf_blacklist');
            /** @var CpfBlacklistEventService $cpfBlacklistEventService */
            $cpfBlacklistEventService = $this->getService('app.service.cpf_blacklist_event');

            $apiListPresenter = $cpfBlacklistService->listCpfApi();
            $cpfBlacklistEventService->registerEventList();

            $responseData = $apiListPresenter->toArray();
            $statusCode = HttpResponse::OK;
        } catch (\Throwable $e) {
            $responseData = [
                'error' => $e->getMessage(),
            ];
            $statusCode = HttpResponse::INTERNAL_SERVER_ERROR;
        } finally {
            return $response->withJson($responseData, $statusCode);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getAction(Request $request, Response $response, array $args): Response
    {
        try {
            $id = (int) $args['id'];

            /** @var CpfBlacklistService $cpfBlacklistService */
            $cpfBlacklistService = $this->getService('app.service.cpf_blacklist');
            /** @var CpfBlacklistEventService $cpfBlacklistEventService */
            $cpfBlacklistEventService = $this->getService('app.service.cpf_blacklist_event');

            /** @var CpfBlacklistPresenter $cpfBlacklistPresenter */
            $cpfBlacklistPresenter = $cpfBlacklistService->getCpfApi($id);

            $cpfBlacklistEventService->registerEventGet(
                $cpfBlacklistPresenter->getCpfBlacklist()
            );

            $responseData = $cpfBlacklistPresenter->toArray();
            $statusCode = HttpResponse::OK;
        } catch (CpfBlacklistNotFoundException $e) {
            $responseData = [
                'error' => $e->getMessage(),
            ];
            $statusCode = HttpResponse::NOT_FOUND;
        } catch (\Throwable $e) {
            $responseData = [
                'error' => $e->getMessage(),
            ];
            $statusCode = HttpResponse::INTERNAL_SERVER_ERROR;
        } finally {
            return $response->withJson($responseData, $statusCode);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function postAction(Request $request, Response $response): Response
    {
        try {
            $number = $request->getParam('number');

            if (!isset($number) || !CpfBlacklist::isValid($number)) {
                throw new CpfInvalidNumberException(
                    sprintf('Cpf with invalid number %s', $number)
                );
            }

            /** @var CpfBlacklistService $cpfBlacklistService */
            $cpfBlacklistService = $this->getService('app.service.cpf_blacklist');
            /** @var CpfBlacklistEventService $cpfBlacklistEventService */
            $cpfBlacklistEventService = $this->getService('app.service.cpf_blacklist_event');

            /** @var CpfBlacklistPresenter $cpfBlacklistPresenter */
            $cpfBlacklistPresenter = $cpfBlacklistService->addCpfApi($number);

            $cpfBlacklistEventService->registerEventAdd(
                $cpfBlacklistPresenter->getCpfBlacklist()
            );

            $responseData = $cpfBlacklistPresenter->toArray();
            $statusCode = HttpResponse::CREATED;
        } catch (CpfInvalidNumberException|CpfBlacklistHasExistException $e) {
            $responseData = [
                'error' => $e->getMessage(),
            ];
            $statusCode = HttpResponse::BAD_REQUEST;
        } catch (\Throwable $e) {
            $responseData = [
                'error' => $e->getMessage(),
            ];
            $statusCode = HttpResponse::INTERNAL_SERVER_ERROR;
        } finally {
            return $response->withJson($responseData, $statusCode);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function deleteAction(Request $request, Response $response, array $args): Response
    {
        try {
            $id = (int) $args['id'];

            /** @var CpfBlacklistService $cpfBlacklistService */
            $cpfBlacklistService = $this->getService('app.service.cpf_blacklist');
            /** @var CpfBlacklistEventService $cpfBlacklistEventService */
            $cpfBlacklistEventService = $this->getService('app.service.cpf_blacklist_event');

            $cpfBlacklist = $cpfBlacklistService->deleteCpf($id);
            $cpfBlacklistEventService->registerEventDelete($cpfBlacklist);

            $responseData = [];
            $statusCode = HttpResponse::NO_CONTENT;
        } catch (CpfBlacklistNotFoundException $e) {
            $responseData = [
                'error' => $e->getMessage(),
            ];
            $statusCode = HttpResponse::NOT_FOUND;
        } catch (\Throwable $e) {
            $responseData = [
                'error' => $e->getMessage(),
            ];
            $statusCode = HttpResponse::INTERNAL_SERVER_ERROR;
        } finally {
            return $response->withJson($responseData, $statusCode);
        }
    }
}
