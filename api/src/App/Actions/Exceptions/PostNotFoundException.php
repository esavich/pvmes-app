<?php

namespace App\Actions\Exceptions;


class PostNotFoundException extends \Exception
{

    /**
     * PostNotFoundException constructor.
     * @param string $msg
     */
    public function __construct(string $msg)
    {
        parent::__construct($msg);
    }
}