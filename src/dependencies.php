<?php
// DIC configuration

use App\Component\Database\Connection;
use App\Repository\CpfBlacklistEventRepository;
use App\Repository\CpfBlacklistRepository;
use Application\Domain\Service\CpfBlacklistEventService;
use Application\Domain\Service\CpfBlacklistService;
use Application\Domain\Service\StatusService;

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};


// sqlite db
$container['db.sqlite'] = function ($c) {
    $settings = $c->get('settings')['database'];

    $connection = new Connection(
        Connection::DRIVER_SQLITE,
        [
            'filePath' => $settings['filePath'],
        ]
    );

    return $connection;
};

// repositories
$container['app.repository.cpf_blacklist'] = function ($c) {
    return new CpfBlacklistRepository(
        $c['db.sqlite']
    );
};

$container['app.repository.cpf_blacklist_event'] = function ($c) {
    return new CpfBlacklistEventRepository(
        $c['db.sqlite']
    );
};

// domain services
$container['app.service.cpf_blacklist'] = function ($c) {
    return new CpfBlacklistService(
        $c['app.repository.cpf_blacklist']
    );
};

$container['app.service.cpf_blacklist_event'] = function ($c) {
    return new CpfBlacklistEventService(
        $c['app.repository.cpf_blacklist_event']
    );
};

$container['app.service.status'] = function ($c) {
    return new StatusService(
        $c['app.service.cpf_blacklist'],
        $c['app.service.cpf_blacklist_event']
    );
};
