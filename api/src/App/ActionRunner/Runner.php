<?php

namespace App\ActionRunner;


use App\Http\Request;

class Runner
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function run($handler)
    {
        if (is_callable($handler)) {
            return $handler($this->request);
        }

        if (is_string($handler) && class_exists($handler)) {
            $handler = new $handler;
            return $handler->run($this->request);
        }

        throw new ActionNotFoundException('action not found');
    }
}