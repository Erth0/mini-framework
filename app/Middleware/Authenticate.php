<?php

namespace App\Middleware;

use Exception;
use App\Auth\Auth;

class Authenticate 
{
    protected $auth;

    public function __construct(Auth $auth) 
    {
        $this->auth = $auth;
    }

    /**
     * Run the function once class has been initialized
     *
     * @param object $request
     * @param object $response
     * @param callable $next
     * @return void
     */
    public function __invoke($request, $response, callable $next)
    {
        if ($this->auth->hasUserInSession()) {
            try {
                $this->auth->setUserFromSession();
            } catch (Exception $e) {
                // $this->auth->logout();
            }
        }
        return $next($request, $response);
    }
}