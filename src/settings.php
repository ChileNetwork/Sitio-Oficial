<?php
return [
    'settings' => [
        'displayErrorDetails' => false, // set to false in production
        'addContentLengthHeader' => true, // Allow the web server to send the content-length header
        
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],
       
        'db' => [
            'host' => 'localhost',
            'port' => '8889',
            'user' => 'root',
            'pass' => 'root',
            'dbname' => 'slimDB',
        ],
         // Monolog settings
        'logger' => [
            'name' => 'slim-app-chilenetwork',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
