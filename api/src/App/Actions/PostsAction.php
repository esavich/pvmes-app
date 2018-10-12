<?php

namespace App\Actions;


use App\Config\Config;
use App\Helpers\PostProcessor;
use App\Http\JsonResponse;
use MongoDB\Client;

class PostsAction
{
    private $allowedOrderBy = [
        'rating',
        'date'
    ];
    private $allowedOrder = [
        'asc' => 1,
        'desc => -1'
    ];
    private $perPage;
    private $criteria = [];
    private $options = [];
    private $collection;

    private $skip;

    public function __construct()
    {
        $mongoClient = new Client(Config::get('mongoUrl'));
        $db = Config::get('db');
        $this->collection = $mongoClient->$db->posts;
        $this->perPage = Config::get('postsPerPage', 20);
    }

    public function run(): JsonResponse
    {

        $this->criteria = $this->getCriteria();
        $this->options = $this->getOptions();


        $totalPosts = $this->collection->countDocuments($this->criteria);
        $totalPageCount = ceil($totalPosts / $this->perPage);
        $posts = $this->collection->find(
            $this->criteria,
            $this->options
        );

        $postsData = [];

        foreach ($posts as $post) {

            $postsData[] = PostProcessor::process($post);
        }
        $responseArr = [
            'totalPosts' => (int)$totalPosts,
            'posts' => $postsData
        ];


        return new JsonResponse($responseArr);
    }

    /**
     * @return array
     */
    public function getCriteria(): array
    {
        $criteria = [];

        if (isset($_GET['tag'])) {
            if (is_array($_GET['tag'])) {
                $criteria['tags'] = ['$all' => $_GET['tag']];
            } else {
                $criteria['tags'] = $_GET['tag'];
            }
        }

        return $criteria;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $this->limit = (int)($_GET['limit'] ?? $this->perPage);

        $this->skip = (int)($_GET['skip'] ?? 0);

        if (isset($_GET['order']) && array_key_exists($_GET['order'], $this->allowedOrder)) {
            $order = $this->allowedOrder[$_GET['order']];
        } else {
            $order = -1;
        }

        if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $this->allowedOrderBy)) {
            $orderBy = $_GET['orderBy'];
        } else {
            $orderBy = 'date';
        }

        $options = [
            'limit' => $this->limit,
            'sort' => [$orderBy => $order],
            'skip' => $this->skip
        ];

        return $options;
    }
}