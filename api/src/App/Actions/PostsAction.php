<?php

namespace App\Actions;


use App\Http\JsonResponse;

class PostsAction
{
    public function run(): JsonResponse
    {
        $responseBody = [
            'data' => ['request' => 'GET /api/posts']
        ];

        return new JsonResponse($responseBody);
    }
}