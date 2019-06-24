<?php
namespace App\Twig;
use Slim\Views\TwigExtension;

class HelpersExtension extends \Twig_Extension
{ 
    public function __construct()
    {
 
    }

    public function getName()
    {
        return 'HelpersExtension';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('class', [$this, 'getClassName'], [
                'needs_environment' => true,
                'is_safe' => ['html']
            ])
        ];
    }

    public function getClassName(\Twig_Environment $environment, $object)
    {
        return strtolower(get_class($object));
    }
}