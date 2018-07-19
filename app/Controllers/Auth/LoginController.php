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
    /**
     * Twig 
     *
     * @var object $auth
     */
    protected $view;

    /**
     * Auth
     *
     * @var object $auth
     */
    protected $auth;

    /**
     * RouteCollection
     *
     * @var object $route
     */
    protected $route;
    
    /**
     * Flash
     *
     * @var object $flash
     */
    protected $flash;

    /**
     * Initializes the given classes when class is created
     *
     * @param View $view
     * @param Auth $auth
     * @param RouteCollection $route
     * @param Flash $flash
     */
    public function __construct(View $view, Auth $auth, RouteCollection $route, Flash $flash) 
    {
        $this->view = $view;
        $this->auth = $auth;
        $this->route = $route;
        $this->flash = $flash;
    }

    /**
     * Returns the login page 
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render($response, 'auth/login.twig');
    }

    /**
     * Sign in the user
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
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
