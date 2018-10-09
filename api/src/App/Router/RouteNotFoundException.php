<?php

namespace App\Router;


class RouteNotFoundException extends \Exception
{

    /**
     * RouteNotFoundException constructor.
     * @param string $msg
     */
    public function __construct(string $msg)
    {
        $this->message = $msg;
    }
}