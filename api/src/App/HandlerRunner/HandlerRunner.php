<?php

namespace App\HandlerRunner;


use App\Router\Result;

class HandlerRunner
{
    public function run(Result $result)
    {

        return call_user_func_array($result->getHandler(), $result->getArgs());
    }
}