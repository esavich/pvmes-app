<?php

use App\Config\Config;

require_once 'vendor/autoload.php';

$config = include_once __DIR__ . '/config.php';
Config::load($config);

$generator = new \App\DummyDataGenerator();

$mongoClient = new \MongoDB\Client(Config::get('mongoUrl'));
$db = Config::get('db');

$postsCollection = $mongoClient->$db->posts;

$posts = $generator->generateNPosts(205);

$postsCollection->insertMany($posts);
$postsCollection->createIndex(['date' => 1]);
$postsCollection->createIndex(['rating' => 1]);
$postsCollection->createIndex(['author' => 1]);
$postsCollection->createIndex(['tags' => 1]);
