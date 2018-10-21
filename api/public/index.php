<?php

use App\ActionRunner\ActionNotFoundException;
use App\ActionRunner\Runner;
use App\Actions\AddCommentAction;
use App\Actions\Exceptions\PostNotFoundException;
use App\Actions\ListCommentAction;
use App\Actions\PostsAction;
use App\Actions\SinglePostAction;
use App\Actions\TagsAction;
use App\Http\JsonResponse;
use App\Http\RequestFactory;
use App\Http\ResponseSender;
use App\Router\RouteNotFoundException;
use App\Router\RoutesCollection;

require_once dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);

$config = include_once dirname(__DIR__) . '/config.php';
App\Config\Config::load($config);

$routesCollection = new RoutesCollection();

$routesCollection->addRoute('/api/tags/', TagsAction::class, ['GET']);
$routesCollection->addRoute('/api/comments/', ListCommentAction::class, ['GET']);
$routesCollection->addRoute('/api/comments/', AddCommentAction::class, ['POST']);

$routesCollection->addRoute('/api/posts/', PostsAction::class, ['GET']);

$routesCollection->addRoute('/api/posts/{id}/', SinglePostAction::class, ['GET'], ['id' => '[\d\w]+']);

$request = RequestFactory::createFromGlobals();

$router = new \App\Router\Router($routesCollection);

$actionRunner = new Runner($request);
try {
    $routeResult = $router->match($request);
    foreach ($routeResult->getArgs() as $argKey => $argVal) {
        $request->addAttribute($argKey, $argVal);
    }
    $response = $actionRunner->run($routeResult->getHandler());
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

} catch (ActionNotFoundException | PostNotFoundException $e) {
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

