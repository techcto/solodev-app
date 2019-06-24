<?php
namespace App\Twig;
use Slim\Views\TwigExtension;

class ModalExtension extends \Twig_Extension
{ 
    public function __construct()
    {
 
    }

    public function getName()
    {
        return 'ModalExtension';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('modal', [$this, 'printModal'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ])
        ];
    }

    public function printModal(\Twig_Environment $environment, $name)
    {
        //View
        $viewData = array(
            'name'=>$name
        );
        if(isset($_REQUEST['tab'])) $viewData["isTab"] = TRUE;
        return $environment->render('./extensions/modal.html.twig', $viewData);
    }
}