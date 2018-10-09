<?php

namespace App\Actions;


class PostsAction
{
    public function run()
    {
        return [
            'data' => ['request' => 'GET /api/posts']
        ];
    }
}