<?php

namespace App\Actions;


use App\Http\JsonResponse;

class SinglePostAction
{
    function run($id): JsonResponse
    {
        $responseBody = [
            'data' => [
                'request' => $_SERVER['REQUEST_METHOD'] . ' /api/posts',
                'id' => $id
            ]
        ];

        return new JsonResponse($responseBody);
    }
}