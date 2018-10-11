<?php

namespace App\Actions;


use App\Config\Config;
use App\Helpers\PostProcessor;
use App\Http\JsonResponse;
use MongoDB\BSON\ObjectId;
use MongoDB\Client;
use MongoDB\Collection;

class SinglePostAction
{
    /**
     * @var Collection
     */
    private $collection;

    public function __construct()
    {
        $mongoClient = new Client(Config::get('mongoUrl'));
        $db = Config::get('db');
        $this->collection = $mongoClient->$db->posts;
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws Exceptions\PostNotFoundException
     */
    function run($id): JsonResponse
    {
        $post = $this->collection->findOne(
            ['_id' => new ObjectId($id)]
        );
        if ($post) {
            $post = PostProcessor::process($post);
            $responseBody = [
                'post' => $post
            ];
            $statusCode = 200;
            $statusText = 'OK';

        } else {
            throw new Exceptions\PostNotFoundException('Post not found');
        }

        return new JsonResponse($responseBody, $statusCode, $statusText);
    }
}