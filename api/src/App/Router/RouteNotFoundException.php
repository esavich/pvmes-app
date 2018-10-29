<?php

namespace App\Router;

class RouteNotFoundException extends \Exception
{
    private $uri;
    private $method;

    /**
     * RouteNotFoundException constructor.
     * @param string $msg
     * @param string $uri
     * @param string $method
     */
    public function __construct(string $msg, string $uri, string $method)
    {
        parent::__construct($msg);
        $this->uri = $uri;
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
