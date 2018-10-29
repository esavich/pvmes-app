<?php

namespace App\Router;

class RoutesCollection
{
    private $routes = [];

    /**
     * @param $pattern
     * @param callable $handler
     * @param array $methods
     * @param array $tokens
     */
    public function addRoute($pattern, $handler, array $methods = [], array $tokens = []): void
    {
        $this->routes[] = [
            'pattern' => $pattern,
            'handler' => $handler,
            'methods' => $methods,
            'tokens' => $tokens
        ];
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
