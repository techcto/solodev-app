<?php
require __DIR__ . '/../vendor/autoload.php';

header('X-Frame-Options: SAMEORIGIN');

// Instantiate the app
$settings = require __DIR__ . '/../config/settings.php';
$app = new \Slim\App($settings);
//GLOBALS for old cms code.
$container = $app->getContainer();  
$GLOBALS['settings'] = $container->get('settings')['app'];
$GLOBALS['cms'] = $container->get('settings')['cms'];
// Set up dependencies
require __DIR__ . '/../config/dependencies.php';
// Register middleware
require __DIR__ . '/../config/middleware.php';
// Register routes
require __DIR__ . '/../config/router.php';

$app->run();