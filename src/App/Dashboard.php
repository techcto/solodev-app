<?php
namespace App\App;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class Dashboard
{
  private $view;
  private $logger;
  
  public function __construct(Twig $view, LoggerInterface $logger, $container)
  {
    $this->container = $container;
    $this->view = $view;
    $this->logger = $logger;
  }
  
  public function __invoke(Request $request, Response $response, $args)
  {
    $route = $request->getAttribute('route');
    $params = $request->getQueryParams();
    $container = $this->container;
    $viewData = array(
    );

    $this->view->render($response, 'dashboard.html.twig', $viewData);
    return $response;
  }
}
