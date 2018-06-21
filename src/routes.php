<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    return $response->withRedirect('/form');
});

$app->get(
    '/form',
    'App\Controller\FormController:showAction'
);

$app->get(
    '/docs',
    'App\Controller\DocsController:showAction'
);

$app->get(
    '/status',
    'App\Controller\StatusController:showAction'
);

$app->get(
    '/consulta',
    'App\Controller\CpfBlacklistController:consultAction'
);

$app->group('/api/v1', function () {
    $this->get(
        '/status',
        'App\Controller\StatusController:showAction'
    );
    $this->group('/cpf/blacklist', function () {
        $this->get(
            '/events',
            'App\Controller\CpfBlacklistEventController:listAction'
        );
        $this->get(
            '/consulta',
            'App\Controller\CpfBlacklistController:consultAction'
        );
        $this->get(
            '',
            'App\Controller\CpfBlacklistController:listAction'
        );
        $this->post(
            '',
            'App\Controller\CpfBlacklistController:postAction'
        );
        $this->get(
            '/{id}',
            'App\Controller\CpfBlacklistController:getAction'
        );
        $this->delete(
            '/{id}',
            'App\Controller\CpfBlacklistController:deleteAction'
        );
    });
});
