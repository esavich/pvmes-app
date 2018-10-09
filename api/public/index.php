<?php

use App\ActionRunner\ActionNotFoundException;
use App\ActionRunner\Runner;
use App\Actions\PostsAction;
use App\Actions\SinglePostAction;
use App\Router\RouteNotFoundException;
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

$actionRunner = new Runner();
try {
    $routeResult = $router->match();
    $response = $actionRunner->run($routeResult);
} catch (RouteNotFoundException $e) {
    $response = [
        'status' => 'error',
        'code' => '404',
        'data' => $e->getMessage(),
        'request' => [
            'uri' => $e->getUri(),
            'method' => $e->getMethod()
        ]
    ];
} catch (ActionNotFoundException $e) {
    $response = [
        'status' => 'error',
        'code' => '404',
        'data' => $e->getMessage(),
    ];
}
header('Content-Type: application/json');
echo json_encode($response);