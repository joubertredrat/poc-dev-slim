<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Controller;

use App\Component\HttpResponse;
use Application\Domain\Service\StatusService;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Status Controller
 *
 * @package App\Controller
 */
class StatusController extends AbstractController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showAction(Request $request, Response $response): Response
    {
        try {
            /** @var StatusService $statusService */
            $statusService = $this->getService('app.service.status');
            $status = $statusService->getStatus();

            $responseData = $status->toArray();
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
}
