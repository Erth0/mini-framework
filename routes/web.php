<?php

$route->get('/', 'App\Controllers\HomeController::index')->setName('home');
// $route->get('/signin', 'App\Controllers\Auth\LoginController::index')->setName('auth.login');
$route->group('/auth', function ($route) {
    $route->get('/signin', 'App\Controllers\Auth\LoginController::index')->setName('auth.login');
    $route->post('/signin', 'App\Controllers\Auth\LoginController::signin');
});