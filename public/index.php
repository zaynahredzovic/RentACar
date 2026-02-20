<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use FastRoute\RouteCollector;
use App\Controllers\AuthController;

// Initialize Dispatcher
$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
    
    // Pages
    $r->addRoute('GET', '/', 'App\Controllers\AuthController@login');
    $r->addRoute('GET', '/signup', 'App\Controllers\AuthController@signup');

    // API
    $r->addRoute('POST', '/api/login', 'App\Controllers\AuthController@loginPost');
    $r->addRoute('POST', '/api/signup', 'App\Controllers\AuthController@signupPost');

    // Dashboard (example protected page)
    $r->addRoute('GET', '/dashboard', 'App\Controllers\DashboardController@index');
});

// Fetch method and URI
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Remove query string (?foo=bar) if present
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

// Decode URI
$uri = rawurldecode($uri);

// Dispatch the route
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo "404 - Page not found";
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo "405 - Method not allowed";
        break;

    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1]; 
        $vars = $routeInfo[2]; 

        // Split controller and method
        list($class, $method) = explode('@', $handler);

        // Instantiate controller and call method
        if(class_exists($class)) {
            $controller = new $class();
            call_user_func_array([$controller, $method], $vars);
        } else {
            echo "Controller $class not found";
        }
        break;
}