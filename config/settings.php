<?php

$clientSettingsEnvPath = __DIR__.'/..';
if (file_exists($clientSettingsEnvPath.'/.env')) {
    $dotenv = Dotenv\Dotenv::create($clientSettingsEnvPath);
    $dotenv->overload();
}

return [
    'settings' => [
        // Slim genereal settings
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        // View settings (template engine Twig)
        'view' => [
            'template_path' => __DIR__ . '/../ui/'
        ],
        'clientSettingsEnvPath' => $clientSettingsEnvPath.'/.env',
        'app' => [
            'var1' => 'solodev',
            'var2' => 'Main',
        ]
    ]
];