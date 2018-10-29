<?php

use App\Actions\AddCommentAction;
use App\Actions\ListCommentAction;
use App\Actions\PostsAction;
use App\Actions\SinglePostAction;
use App\Actions\TagsAction;
use App\Router\Router;
use App\Router\RoutesCollection;

$routesCollection = new RoutesCollection();
$routesCollection->addRoute('/api/tags/', TagsAction::class, ['GET']);
$routesCollection->addRoute('/api/comments/', ListCommentAction::class, ['GET']);
$routesCollection->addRoute('/api/comments/', AddCommentAction::class, ['POST']);
$routesCollection->addRoute('/api/posts/', PostsAction::class, ['GET']);
$routesCollection->addRoute('/api/posts/{id}/', SinglePostAction::class, ['GET'], ['id' => '[\d\w]+']);
$router = new Router($routesCollection);

return $router;
