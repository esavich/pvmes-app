<?php
require_once 'vendor/autoload.php';
$generator = new \App\DummyDataGenerator();

$mongoClient = new \MongoDB\Client('mongodb://mongo:27017');

$postsCollection = $mongoClient->pvmes->posts;

$posts = $generator->generateNPosts(205);

$postsCollection->insertMany($posts);
$postsCollection->createIndex(['date' => 1]);
$postsCollection->createIndex(['rating' => 1]);
$postsCollection->createIndex(['author' => 1]);
$postsCollection->createIndex(['tags' => 1]);