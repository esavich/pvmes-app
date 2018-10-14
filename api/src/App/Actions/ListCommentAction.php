<?php

namespace App\Actions;


use App\Config\Config;
use App\Helpers\CommentProcessor;
use App\Http\JsonResponse;
use MongoDB\BSON\ObjectId;
use MongoDB\Client;


class ListCommentAction
{
    /**
     * @var \MongoDB\Collection
     */
    private $collection;
    private $criteria = [];
    private $options = [];

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
        $this->criteria = $this->getCriteria();
        $this->options = $this->getOptions();

        $comments = $this->collection->find(
            $this->criteria,
            $this->options
        );

        $commentsData = [];

        foreach ($comments as $comment) {
            $commentsData[] = CommentProcessor::process($comment);
        }
        $responseBody = [

            'comments' => $commentsData
        ];
        return new JsonResponse($responseBody);
    }

    /**
     * @return array
     */
    public function getCriteria(): array
    {
        $criteria = [];

        if (isset($_GET['postId'])) {
            $criteria['postId'] = new ObjectId($_GET['postId']);
        }

        return $criteria;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $options = [
            'sort' => ['date' => -1],
        ];

        return $options;
    }
}