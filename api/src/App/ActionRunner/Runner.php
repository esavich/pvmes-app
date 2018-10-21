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

    /**
     * @param $handler
     * @return mixed
     * @throws ActionNotFoundException
     */
    public function run($handler)
    {
        //если экшен уже callable (например просто анонимная функция)
        if (is_callable($handler)) {
            return $handler($this->request);
        }
        //если экшен строка и есть такой класс, то создаем экземпляр и запускаем
        if (is_string($handler) && class_exists($handler)) {
            $handler = new $handler;
            return $handler->run($this->request);
        }

        throw new ActionNotFoundException('action not found');
    }
}