<?php

$clientSettingsEnvPath = __DIR__.'/../../../../../clients/solodev';
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

        // Check if using SSL
        'isSSL' => (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 
            $_SERVER['SERVER_PORT'] == 443 || 
            ($_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'] && $_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'] == "https") ||
            ($_SERVER['HTTP_X_FORWARDED_PROTO'] && $_SERVER['HTTP_X_FORWARDED_PROTO'] == "https")
        ),
        // CLIENT SETTINGS
        'clientSettingsEnvPath' => $clientSettingsEnvPath.'/.env',

        // jwt settings
        'jwt'  => [
            'secret' => getenv('SOLODEV_SECRET'),
            'secure' => false,
            "header" => "Authorization",
            'passthrough' => ['OPTIONS']
        ],

        'app' => [
            'var1' => 'solodev',
            'var2' => 'Main',
        ]
    ]
];