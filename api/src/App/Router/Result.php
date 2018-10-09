<?php

namespace App\Router;


class Result
{
    private $handler;
    private $args;

    /**
     * Result constructor.
     * @param callable $handler
     * @param array $args
     */
    public function __construct(callable $handler, array $args)
    {
        $this->handler = $handler;
        $this->args = $args;
    }

    /**
     * @return callable
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }
}