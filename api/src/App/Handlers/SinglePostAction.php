<?php

namespace App\Handlers;


class SinglePostAction
{
    function run($id)
    {

        return [
            'data' => [
                'request' => $_SERVER['REQUEST_METHOD'] . ' /api/posts',
                'id' => $id
            ]
        ];
    }
}