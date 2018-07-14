<?php

namespace App\Views;

use Twig_Environment;
use Psr\Http\Message\ResponseInterface;

class View 
{   
    /**
     * Twig environment instance
     *
     * @var object
     */
    protected $twig;

    public function __construct(Twig_Environment $twig) 
    {
        $this->twig = $twig;
    }

    /**
     * Render to the view
     *
     * @param ResponseInterface $response
     * @param object $view
     * @param array $data
     * @return $twig response
     */
    public function render(ResponseInterface $response, $view, $data = [])
    {
        $response->getBody()->write(
            $this->twig->render($view, $data)
        );

        return $response;
    }

    public function share(array $data)
    {
        foreach ($data as $key => $value) {
            $this->twig->addGlobal($key, $value);
        }
    }
}