<?php

namespace App\Actions;

use App\Config\Config;
use App\Http\JsonResponse;
use App\Http\Request;
use MongoDB\Client;

class TagsAction implements ActionInterface
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

    public function run(Request $request): JsonResponse
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
