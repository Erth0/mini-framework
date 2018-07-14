<?php 

/**
 * Start Session
 */
session_start();

/**
 * Require Once the autoload.php 
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Check if we have a dotenv file
 */
try {
    $dotenv = (new Dotenv\Dotenv(base_path()))->load();
} catch(\Dotenv\Exception\InvalidPathException $e) {
    #
}


/**
 * Require Once container.php
 */
require_once base_path('bootstrap/container.php');

$session = $container->get(\App\Session\SessionStore::class);



/**
 * Initialize The RouteCollection::class
 */
$route = $container->get(\League\Route\RouteCollection::class);

/**
 * Require Once middleware.php
 */
require_once base_path('bootstrap/middleware.php');


/**
 * Require Once web.php
 */
require_once base_path('routes/web.php');

/**
 * Assigning to response the dispathced route with the request and response classes
 */
try {
    $response = $route->dispatch($container->get('request'), $container->get('response'));
} catch (Exception $e) {
    $handler = new \App\Exceptions\Handler($e, $container->get(\App\Session\SessionStore::class));

    $response = $handler->respond();
}

