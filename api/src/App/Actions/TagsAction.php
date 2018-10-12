<?php

namespace App\Actions;


use App\Config\Config;
use App\Http\JsonResponse;
use MongoDB\Client;

class TagsAction
{
    /**
     * @var \MongoDB\Collection
     */
    private $collection;

    public function __construct()
    {
        $mongoClient = new Client(Config::get('mongoUrl'));
        $db = Config::get('db');
        $this->collection = $mongoClient->$db->posts;
    }

    function run(): JsonResponse
    {
        $tags = $this->collection->aggregate([
            ['$unwind' => '$tags'],
            ['$group' => ['_id' => '$tags', 'count' => ['$sum' => 1]]],
            ['$sort' => ['count' => -1]]
        ])->toArray();
//        var_dump($tags);
        $responseBody = [
            'tags' => $tags
        ];

        return new JsonResponse($responseBody);
    }
}