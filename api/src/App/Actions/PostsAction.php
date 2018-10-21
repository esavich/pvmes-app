<?php

namespace App\Actions;


use App\Config\Config;
use App\Helpers\PostProcessor;
use App\Http\JsonResponse;
use App\Http\Request;
use MongoDB\Client;

class PostsAction implements ActionInterface
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
    /**
     * @var Request
     */
    private $request;

    public function __construct()
    {
        $mongoClient = new Client(Config::get('mongoUrl'));
        $db = Config::get('db');
        $this->collection = $mongoClient->$db->posts;
        $this->perPage = Config::get('postsPerPage', 20);
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


        $totalPosts = $this->collection->countDocuments($this->criteria);
        $posts = $this->collection->find(
            $this->criteria,
            $this->options
        );

        $postsData = [];

        foreach ($posts as $post) {

            $postsData[] = PostProcessor::process($post);
        }
        $responseBody = [
            'totalPosts' => (int)$totalPosts,
            'posts' => $postsData
        ];


        return new JsonResponse($responseBody);
    }

    /**
     * @return array
     */
    public function getCriteria(): array
    {
        $criteria = [];

        if ($this->request->getParam('tag')) {
            if (is_array($this->request->getParam('tag'))) {
                $criteria['tags'] = ['$all' => $this->request->getParam('tag')];
            } else {
                $criteria['tags'] = $this->request->getParam('tag');
            }
        }

        return $criteria;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $this->limit = (int)($this->request->getParam('limit') ?? $this->perPage);

        $this->skip = (int)($this->request->getParam('skip') ?? 0);

        if ($this->request->getParam('order') && array_key_exists($this->request->getParam('order'), $this->allowedOrder)) {
            $order = $this->allowedOrder[$this->request->getParam('order')];
        } else {
            $order = -1;
        }

        if ($this->request->getParam('orderBy') && in_array($this->request->getParam('orderBy'), $this->allowedOrderBy)) {
            $orderBy = $this->request->getParam('orderBy');
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