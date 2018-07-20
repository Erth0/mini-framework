<?php

namespace App\Middleware;

use Exception;
use App\Auth\Auth;

class AuthenticateFromCookie 
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
        if ($this->auth->check()) {
            return $next($request, $response);
        }

        if ($this->auth->hasRecaller()) {
            try {
                $this->auth->setUserFromCookie();
            } catch (Exception $e) {
                $this->auth->logout();
            }
        }

        return $next($request, $response);
    }
}