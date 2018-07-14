<?php

namespace App\Views\Extensions;

use Twig_Extension;
use Twig_SimpleFunction;
use League\Route\RouteCollection;

class PathExtension extends Twig_Extension
{
    protected $route;

    public function __construct(RouteCollection $route) 
    {
        $this->route = $route;
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('route', [$this, 'route'])
        ];
    }

    public function route($name)
    {
        return $this->route->getNamedRoute($name)->getPath();
    }
}