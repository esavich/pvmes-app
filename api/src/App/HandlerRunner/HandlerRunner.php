<?php

namespace App\HandlerRunner;


use App\Router\Result;

class HandlerRunner
{
    public function run(Result $result)
    {
        $handler = $result->getHandler();
        if (!is_callable($handler) && is_string($handler)) {
            if (class_exists($handler)) {
                $handler = [new $handler, 'run'];
            } else {
                throw new HandlerNotFoundException();
            }
        }
        return call_user_func_array($handler, $result->getArgs());
    }
}