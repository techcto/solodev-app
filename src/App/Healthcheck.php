<?php
namespace App;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class Healthcheck
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
    $error = "";
    $user = \User_Manager::getCurrentUser();

    $viewData = array(
      'message'=>"alive"
    );
    $this->view->render($response, 'healthcheck.html.twig', $viewData);
    return $response;
  }

}
