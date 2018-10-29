<?php

namespace Tests;

use App\Http\Request;
use App\Router\Result;
use App\Router\RouteNotFoundException;
use App\Router\Router;
use App\Router\RoutesCollection;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    /**
     * @var Router
     */
    private $router;

    public function testMatchValid()
    {
        $request = new Request([], [], '/api/test/');
        $result = $this->router->match($request);
        $this->assertInstanceOf(Result::class, $result);
    }

    public function testMatchInvalidPath()
    {
        $this->expectException(RouteNotFoundException::class);
        $request = new Request([], [], '/api/test2/');
        $result = $this->router->match($request);
    }

    public function testMatchInvalidMethod()
    {
        $this->expectException(RouteNotFoundException::class);
        $request = new Request([], [], '/api/test/');
        $request->setMethod('POST');
        $result = $this->router->match($request);
    }

    protected function setUp()
    {
        $routesCollection = new RoutesCollection();
        $routesCollection->addRoute('/api/test/', function () {
        }, ['GET']);
        $this->router = new Router($routesCollection);
    }
}
