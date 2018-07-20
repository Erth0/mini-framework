<?php

namespace App\Controllers\Auth;

use App\Views\View;
use App\Controllers\Controller;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Auth\Auth;
use League\Route\RouteCollection;
use App\Session\Flash;
use App\Models\User;
use App\Auth\Hashing\Hasher;
use Doctrine\ORM\EntityManager;

class RegistrationController extends Controller
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
     * Hasher
     *
     * @var $hash
     */
    protected $hash;

    /**
     * RouteCollection
     *
     * @var $route
     */
    protected $route;
    
    /**
     * EntityManager
     *
     * @var $db
     */
    protected $db;

    /**
     * Initializes the given classes when class is created
     *
     * @param View $view
     */
    public function __construct(View $view, Hasher $hash, RouteCollection $route, EntityManager $db, Auth $auth) 
    {
        $this->view = $view;
        $this->hash = $hash;
        $this->route = $route;
        $this->db = $db;
        $this->auth = $auth;
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
        return $this->view->render($response, 'auth/register.twig');
    }

    /**
     * Sign in the user
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
    public function register(RequestInterface $request, ResponseInterface $response)
    {
        $data = $this->validateRegistration($request);

        $user = $this->createUser($data);

        if(!$this->auth->attempt($data['email'], $data['password']))
        {
            return redirect('/');
        }

        return redirect($this->route->getNamedRoute('home')->getPath());
    }

    protected function createUser($data) 
    {
        $user = new User;

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $this->hash->create($data['password'])
        ]);

        $this->db->persist($user);
        $this->db->flush();

        return $user;

    }

    protected function validateRegistration($request)
    {
        return $this->validate($request, [
            'email' => ['required', 'email', ['exists', User::class]],
            'name' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required', ['equals', 'password']]
        ]);
    }
}
