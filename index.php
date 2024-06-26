<?php

require 'vendor/autoload.php';
require 'bootstrap.php';

// Set up the routing

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    require 'web.php';

    $r->addGroup('/api/v1', function (FastRoute\RouteCollector $r) {
        require 'api.php';
    });
});

// Recommended FastRoute setup from the docs

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        call_user_func($handler, $vars);
        break;
}