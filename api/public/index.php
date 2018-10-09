<?php

use App\HandlerRunner\HandlerRunner;
use App\Handlers\PostsAction;
use App\Handlers\SinglePostAction;
use App\Router\RoutesCollection;

require_once dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);

$routesCollection = new RoutesCollection();

$routesCollection->addRoute('/api/', function () {

    return [
        'data' => ['request' => 'GET /api']
    ];
}, ['GET']);

$routesCollection->addRoute('/api/', function () {

    return [
        'data' => ['request' => 'POST /api']
    ];
}, ['POST']);

$routesCollection->addRoute('/api/posts/', PostsAction::class, ['GET']);

$routesCollection->addRoute('/api/posts/{id}/', SinglePostAction::class, ['GET', 'POST'], ['id' => '\d']);

$router = new \App\Router\Router($routesCollection);

$handlerRunner = new HandlerRunner();
try {
    $routeResult = $router->match();
    $response = $handlerRunner->run($routeResult);
} catch (\App\Router\RouteNotFoundException $e) {
    $response = [
        'status' => 'error',
        'code' => '404',
        'data' => $e->getMessage(),
        'request' => [
            'uri' => $e->getUri(),
            'method' => $e->getMethod()
        ]
    ];
}
header('Content-Type: application/json');
echo json_encode($response);