<?php

namespace App\Router;


use App\Http\Request;

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
     * @param Request $request
     * @return Result
     * @throws RouteNotFoundException
     */
    public function match(Request $request)
    {
        $collection = $this->routesCollection->getRoutes();

        $method = $request->getMethod();
        $requestUri = $request->getUrlPart('path');

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