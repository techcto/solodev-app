<?php
namespace App\App;

use Slim\Views\Twig;
use Slim\Http\Request;
use Slim\Http\Response;

final class Healthcheck
{
  private $view;

  public function __construct(Twig $view, $container)
  {
    $this->container = $container;
    $this->view = $view;
  }

  public function __invoke(Request $request, Response $response, $args)
  {
    $viewData = [
      'message' => "alive"
    ];

    $this->view->render($response, 'healthcheck.html.twig', $viewData);
    return $response;
  }

}
