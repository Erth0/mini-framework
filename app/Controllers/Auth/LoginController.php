<?php

namespace App\Controllers\Auth;

use App\Views\View;
use App\Controllers\Controller;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Auth\Auth;
use League\Route\RouteCollection;
use App\Session\Flash;

class LoginController extends Controller
{
    protected $view;

    protected $auth;

    protected $route;

    protected $flash;

    public function __construct(View $view, Auth $auth, RouteCollection $route, Flash $flash) 
    {
        $this->view = $view;
        $this->auth = $auth;
        $this->route = $route;
        $this->flash = $flash;
    }


    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render($response, 'auth/login.twig');
    }


    public function signin(RequestInterface $request, ResponseInterface $response)
    {
        $data = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $attempt = $this->auth->attempt($data['email'], $data['password']);

        if (!$attempt) {
            $this->flash->now('error', 'Something went wrong');

            return redirect($request->getUri()->getPath());
        }

        return redirect($this->route->getNamedRoute('home')->getPath());
    }
}
