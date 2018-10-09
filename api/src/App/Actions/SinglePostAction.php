<?php

namespace App\Actions;


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