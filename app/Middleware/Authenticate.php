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