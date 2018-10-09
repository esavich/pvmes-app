<?php

namespace App\ActionRunner;


use App\Router\Result;

class Runner
{
    public function run(Result $result)
    {
        $handler = $result->getHandler();
        if (!is_callable($handler) && is_string($handler)) {
            if (class_exists($handler)) {
                $handler = [new $handler, 'run'];
            } else {
                throw new ActionNotFoundException('action ' . $handler . ' not found');
            }
        }
        return call_user_func_array($handler, $result->getArgs());
    }
}