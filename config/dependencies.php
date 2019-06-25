<?php

// Boot Portal Core
//include_once(dirname(__FILE__) . '/../../modules/portal/includes/Portal_Core.inc');
//$container['portal'] = new Portal_Core();
//$container['userManager'] = new User_Manager();

// Register Flash Messages
$container['flash'] = function ($container) {
  return new \Slim\Flash\Messages;
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Page not found moo');
    };
};

// Register CSRF Protection
$container['csrf'] = function ($container) {
  $guard = new \Slim\Csrf\Guard();
  $guard->setPersistentTokenMode(true);
  $guard->setFailureCallable(function ($request, $response, $next) {
      $route = $request->getAttribute('route');
      //check for routes to ignore
      $routeName = $route->getName();
      if ($routeName == 'Forgot Password' || $routeName == 'Forgot Reset' || $routeName == 'Accept Invite' || $routeName == 'Post App') {
        return $next($request, $response);
      }

      //Otherwise send error message
      $body = new \Slim\Http\Body(fopen('php://temp', 'r+'));
      $body->write('CSRF values are not vaild. Please try again...');
      return $response->withStatus(400)->withHeader('Content-type', 'text/plain')->withBody($body);
  });
 // return $guard;
};

// Register Logger
$container['logger'] = function ($c) {
  $settings = $c->get('settings');
  $logger = new Monolog\Logger($settings['logger']['name']);
  $logger->pushProcessor(new Monolog\Processor\UidProcessor());
  $logger->pushHandler(new Monolog\Handler\StreamHandler(dirname(__FILE__) . '/../../tmp/app.log', Monolog\Logger::DEBUG));
  return $logger;
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

  //CSRF
  //$view->addExtension(new App\Twig\CsrfExtension($container->get('csrf')));

  //Helpers
  $view->addExtension(new App\Twig\HelpersExtension());

  //Modal
  $view->addExtension(new App\Twig\ModalExtension());

  $filter = new Twig_SimpleFilter('cast_to_array', function ($stdClassObject) {
    $response = (array)$stdClassObject;
    return $response;
  });
  $view->getEnvironment()->addFilter($filter);


  $tablenamefilter = new Twig_SimpleFilter('preg_replace', function ($subject, $pattern, $replacement) {
    return preg_replace($pattern, $replacement, $subject);
  });
  $view->getEnvironment()->addFilter($tablenamefilter);


  //Debug
  //$view->addExtension(new Twig_Extension_Debug());

  //Add Flash Messages into View
  //$view->getEnvironment()->addGlobal('flash', $container->flash);
  $routeParts = explode("/",$container->get('request')->getUri()->getPath());
  $view->getEnvironment()->addGlobal('currentView', $routeParts[1]);
  
  return $view;
};

///// App /////
$container[App\Healthcheck::class] = function ($c) {
  return new App\Healthcheck($c->get('view'), $c->get('logger'),$c);
};
$container[App\Dashboard::class] = function ($c) {
  return new App\Dashboard($c->get('view'), $c->get('logger'),$c);
};