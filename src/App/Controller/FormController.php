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
 * Form Controller
 *
 * @package App\Controller
 */
class FormController extends AbstractController
{
    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function showAction(Request $request, Response $response): Response
    {
        return $this->container->renderer->render($response, 'form.phtml');
    }
}
