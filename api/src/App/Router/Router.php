<?php

namespace App\Router;


class Router
{
    private $routesCollection;

    /**
     * Router constructor.
     * @param RoutesCollection $routesCollection
     */
    public function __construct(RoutesCollection $routesCollection)
    {
        $this->routesCollection = $routesCollection;
    }

    /**
     * @return Result
     * @throws RouteNotFoundException
     */
    public function match()
    {
        $collection = $this->routesCollection->getRoutes();

        $method = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['SCRIPT_NAME'];

        foreach ($collection as $route) {
            if (!empty($route['methods']) && !in_array($method, $route['methods'])) {
                continue;
            }


            $pattern = preg_replace_callback('@\{([^\}]+)\}@', function ($matches) use ($route) {
                $arg = $matches[1];
                $replace = $route['tokens'][$arg] ?? '[^}]+';
                return '(?P<' . $arg . '>' . $replace . ')';
            }, $route['pattern']);


            $pattern = '@^' . $pattern . '$@i';

            if (preg_match($pattern, $requestUri, $matches)) {
                return new Result($route['handler'], array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY));
            }
        }

        throw new RouteNotFoundException('Route not found', $requestUri, $method);
    }
}