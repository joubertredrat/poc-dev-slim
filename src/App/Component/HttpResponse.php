<?php
/**
 * Dev Test
 *
 * @author Joubert RedRat <me+github@redrat.com.br>
 */

namespace App\Component;

/**
 * Http Response
 *
 * @package App\Component
 */
class HttpResponse
{
    /**
     * Available status code response
     */
    const OK = 200;
    const CREATED = 201;
    const NO_CONTENT = 204;
    const BAD_REQUEST = 400;
    const NOT_FOUND = 404;
    const INTERNAL_SERVER_ERROR = 500;
}
