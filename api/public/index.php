<?php

use App\ActionRunner\ActionNotFoundException;
use App\ActionRunner\Runner;
use App\Actions\PostsAction;
use App\Actions\SinglePostAction;
use App\Http\JsonResponse;
use App\Http\ResponseSender;
use App\Router\RouteNotFoundException;
use App\Router\RoutesCollection;

require_once dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);

$config = include_once dirname(__DIR__) . '/config.php';
App\Config\Config::load($config);

$routesCollection = new RoutesCollection();

$routesCollection->addRoute('/api/posts/', PostsAction::class, ['GET']);

$routesCollection->addRoute('/api/posts/{id}/', SinglePostAction::class, ['GET', 'POST'], ['id' => '\d']);

$router = new \App\Router\Router($routesCollection);

$actionRunner = new Runner();
try {
    $routeResult = $router->match();
    $response = $actionRunner->run($routeResult);
} catch (RouteNotFoundException $e) {
    $responseBody = [
        'status' => 'error',
        'code' => '404',
        'data' => $e->getMessage(),
        'request' => [
            'uri' => $e->getUri(),
            'method' => $e->getMethod()
        ]
    ];
    $response = new JsonResponse($responseBody, '404', 'Not Found');

} catch (ActionNotFoundException $e) {
    $responseBody = [
        'status' => 'error',
        'code' => '404',
        'data' => $e->getMessage(),
    ];
    $response = new JsonResponse($responseBody, '404', 'Not Found');
}
//$response->addHeader('test', 'test1');
//$response->addHeader('test', 'test2');
//$response->removeHeader('test');
//$response->setStatus('500');
ResponseSender::send($response);

