<?php

namespace App\Actions;

use App\Config\Config;
use App\Helpers\CommentProcessor;
use App\Http\JsonResponse;
use App\Http\Request;
use MongoDB\BSON\ObjectId;
use MongoDB\Client;

class ListCommentAction implements ActionInterface
{
    /**
     * @var \MongoDB\Collection
     */
    private $collection;
    private $criteria = [];
    private $options = [];
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

        if ($this->request->getParam('postId')) {
            $criteria['postId'] = new ObjectId($this->request->getParam('postId'));
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
