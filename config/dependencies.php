<?php

$container['environment'] = function () {
  $urlParts = explode("/",$_SERVER['REQUEST_URI']);
  $_SERVER['SCRIPT_NAME'] = '/apps/' . $urlParts[2] . "/view";
  return new Slim\Http\Environment($_SERVER);
};

// Register Twig Templates
$container['view'] = function ($container) {
  $view = new \Slim\Views\Twig(dirname(__FILE__) . '/../ui', [
    // 'cache' => '../../tmp/cache'
  ]);
  
  // Instantiate and add Slim specific extension
  $router = $container->get('router');
  $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
  $view->addExtension(new Slim\Views\TwigExtension($router, $uri));
 
  return $view;
};

///// App /////
$container[App\App\Healthcheck::class] = function ($c) {
  return new App\App\Healthcheck($c->get('view'), $c);
};
$container[App\App\Dashboard::class] = function ($c) {
  return new App\App\Dashboard($c->get('view'), $c);
};