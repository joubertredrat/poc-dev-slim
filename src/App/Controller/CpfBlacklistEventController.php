<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Controller;

use App\Component\HttpResponse;
use Application\Domain\Exception\Cpf\Blacklist\Event\InvalidSortException as CpfBlacklistEventInvalidSortException;
use Application\Domain\Exception\Cpf\Blacklist\Event\InvalidTypeException as CpfBlacklistEventInvalidTypeException;
use Application\Domain\Service\CpfBlacklistEventService;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Cpf Blacklist Event Controller
 *
 * @package App\Controller
 */
class CpfBlacklistEventController extends AbstractController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function listAction(Request $request, Response $response): Response
    {
        try {
            /** @var CpfBlacklistEventService $cpfBlacklistEventService */
            $cpfBlacklistEventService = $this->getService('app.service.cpf_blacklist_event');

            $sort = $request->getQueryParam('sort', null);
            $type = $request->getQueryParam('type', null);
            $cpf = $request->getQueryParam('cpf', null);

            $apiListPresenter = $cpfBlacklistEventService->listEventsApi($sort, $cpf, $type);

            $responseData = $apiListPresenter->toArray();
            $statusCode = HttpResponse::OK;
        } catch (CpfBlacklistEventInvalidSortException|CpfBlacklistEventInvalidTypeException $e) {
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
}
