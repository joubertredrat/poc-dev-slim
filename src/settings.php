<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Database settings
        'database' => [
            'filePath' => __DIR__ . '/../db/file.sqlite'
        ],

        // Commands
        'commands' => [
            'db:database:create' => \App\Command\Database\DatabaseCreateCommand::class,
            'db:database:drop' => \App\Command\Database\DatabaseDropCommand::class,
            'db:schema:create' => \App\Command\Database\SchemaCreateCommand::class,
            'db:schema:drop' => \App\Command\Database\SchemaDropCommand::class,
        ],
    ],
];
