<?php

namespace App\Views\Extensions;

use Twig_Extension;
use Twig_SimpleFunction;
use League\Route\RouteCollection;

class PathExtension extends Twig_Extension
{
    /**
     * RouteCollection
     *
     * @var $route
     */     
    protected $route;

    public function __construct(RouteCollection $route) 
    {
        $this->route = $route;
    }

    /**
     * Returns array of twig function
     *
     * @return void
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('route', [$this, 'route'])
        ];
    }
    
    /**
     * Get the path name 
     *
     * @param string $name
     * @return void
     */
    public function route($name)
    {
        return $this->route->getNamedRoute($name)->getPath();
    }
}