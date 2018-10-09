<?php

namespace App\Handlers;


class PostsAction
{
    public function run()
    {
        return [
            'data' => ['request' => 'GET /api/posts']
        ];
    }
}