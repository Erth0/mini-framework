<?php

namespace App\Controllers;

use App\Views\View;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class DashboardController
{
    /**
     * Twig Template
     *
     * @var object $view
     */
    protected $view;

    public function __construct(View $view) 
    {
        $this->view = $view;
    }

    /**
     * Returns an twig rendered template for home
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        // dump($this->hash->create('password'));

        // die();

        return $this->view->render($response, 'dashboard/index.twig');
    }
}
