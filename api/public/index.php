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

//подключение конфига
$config = include_once dirname(__DIR__) . '/config.php';
App\Config\Config::load($config);

//создание и подключение роутера
/** @var App\Router\Router $router */
$router = include_once dirname(__DIR__) . '/routes.php';

//создание объекта запроса
$request = RequestFactory::createFromGlobals();

$actionRunner = new Runner($request);

try { //пробуем найти роут
    $routeResult = $router->match($request);
    //добавляем атрибуты в запрос
    foreach ($routeResult->getArgs() as $argKey => $argVal) {
        $request->addAttribute($argKey, $argVal);
    }
    //получаем ответ из экшена
    $response = $actionRunner->run($routeResult->getHandler());
} catch (RouteNotFoundException $e) { //роут не найден
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
} catch (ActionNotFoundException | PostNotFoundException $e) { //экшен не найден или пост не найден
    $responseBody = [
        'status' => 'error',
        'code' => '404',
        'data' => $e->getMessage(),
    ];
    $response = new JsonResponse($responseBody, '404', 'Not Found');
}
//отправляем ответ
ResponseSender::send($response);
