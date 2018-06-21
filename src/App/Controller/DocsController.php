<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Docs Controller
 *
 * @package App\Controller
 */
class DocsController extends AbstractController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showAction(Request $request, Response $response): Response
    {
        return $this->container->renderer->render($response, 'docs.phtml');
    }
}
