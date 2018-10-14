<?php

namespace App\Actions;


use App\Config\Config;
use App\Http\JsonResponse;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Client;


class AddCommentAction
{
    /**
     * @var \MongoDB\Collection
     */
    private $collection;


    public function __construct()
    {
        $mongoClient = new Client(Config::get('mongoUrl'));
        $db = Config::get('db');
        $this->collection = $mongoClient->$db->comments;
    }

    /**
     * @return JsonResponse
     */
    public function run(): JsonResponse
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $data = array_map('trim', $data);
        $responseBody = [];
        if ($this->validate($data)) {
            $this->collection->insertOne([
                'postId' => new ObjectId($data['postId']),
                'name' => $data['name'],
                'email' => $data['email'],
                'comment' => $data['comment'],
                'date' => new UTCDateTime()
            ]);
            $responseBody['status'] = 'success';
        } else {
            $responseBody['status'] = 'error';
        }
        return new JsonResponse($responseBody);
    }

    /**
     * @param $data
     * @return bool
     */
    private function validate($data): bool
    {
        if (
            isset($data['name'])
            && is_string($data['name'])
            && isset($data['email'])
            && filter_var($data['email'], FILTER_VALIDATE_EMAIL)
            && isset($data['comment'])
            && is_string($data['comment'])
            && isset($data['postId'])
            && is_string($data['postId'])
        ) {
            return true;
        }

        return false;
    }
}