<?php

use App\ActionRunner\ActionNotFoundException;
use App\ActionRunner\Runner;
use App\Actions\Exceptions\PostNotFoundException;
use App\Http\JsonResponse;
use App\Http\RequestFactory;
use App\Http\ResponseSender;
use App\Router\RouteNotFoundException;

require_once dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);

$config = include_once dirname(__DIR__) . '/config.php';
App\Config\Config::load($config);


$router = include_once dirname(__DIR__) . '/routes.php';

$request = RequestFactory::createFromGlobals();

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

