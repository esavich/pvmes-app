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
        $this->assertEquals(TestAction::class, $result->getHandler());
    }

    public function testMatchValidWithAttributes()
    {
        $request = new Request([], [], '/api/testattribute/123');
        $request->setMethod('POST');
        $result = $this->router->match($request);
        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals(TestAction::class, $result->getHandler());
        $this->assertEquals(['id' => 123], $result->getArgs());
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
        $routesCollection->addRoute('/api/test/', TestAction::class, ['GET']);
        $routesCollection->addRoute('/api/testattribute/{id}', TestAction::class, ['POST'], ['id' => '\d+']);
        $this->router = new Router($routesCollection);
    }
}
