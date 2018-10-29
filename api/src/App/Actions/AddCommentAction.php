<?php

namespace App\Actions;

use App\Config\Config;
use App\Http\JsonResponse;
use App\Http\Request;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Client;

class AddCommentAction implements ActionInterface
{
    /**
     * @var \MongoDB\Collection
     */
    private $collection;
    /**
     * @var Request
     */
    private $request;


    public function __construct()
    {
        $mongoClient = new Client(Config::get('mongoUrl'));
        $db = Config::get('db');
        $this->collection = $mongoClient->$db->comments;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function run(Request $request): JsonResponse
    {
        $this->request = $request;

        $this->trimRequestData();

        $responseBody = [];
        if ($this->validate()) {
            $this->collection->insertOne([
                'postId' => new ObjectId($this->request->getPost('postId')),
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'comment' => $this->request->getPost('comment'),
                'date' => new UTCDateTime()
            ]);
            $responseBody['status'] = 'success';
        } else {
            $responseBody['status'] = 'error';
        }
        return new JsonResponse($responseBody);
    }

    private function trimRequestData()
    {
        $body = $this->request->getBody();
        $res = array_walk_recursive($body, function (&$item) {
            $item = trim($item);
        });

        $this->request->setBody($body);
    }

    /**
     * @return bool
     */
    private function validate(): bool
    {
        if (
            $this->request->getPost('name')
            && is_string($this->request->getPost('name'))
            && $this->request->getPost('email')
            && filter_var($this->request->getPost('email'), FILTER_VALIDATE_EMAIL)
            && $this->request->getPost('comment')
            && is_string($this->request->getPost('comment'))
            && $this->request->getPost('postId')
            && is_string($this->request->getPost('postId'))
        ) {
            return true;
        }

        return false;
    }
}
