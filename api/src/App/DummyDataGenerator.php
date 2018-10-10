<?php

namespace App;


use Faker\Factory;

class DummyDataGenerator
{
    private $authors = [];
    private $tags = [];
    private $faker;

    /**
     * DummyDataGenerator constructor.
     * @param int $authorsNum
     * @param int $tagsNum
     */
    public function __construct(int $authorsNum = 10, int $tagsNum = 30)
    {
        $this->faker = Factory::create();
        $this->generateAuthors($authorsNum);
        $this->generateTags($tagsNum);
    }

    private function generateAuthors(int $authorsNum)
    {
        for ($i = 0; $i < $authorsNum; $i++) {
            $this->authors[] = $this->faker->name;
        }
    }

    private function generateTags(int $tagsNum)
    {
        for ($i = 0; $i < $tagsNum; $i++) {
            $this->tags[] = $this->faker->unique()->colorName;
        }
    }

    public function generateNPosts(int $n = 1)
    {
        $posts = [];
        for ($i = 0; $i < $n; $i++) {
            $posts[] = $this->generatePost();
        }

        return $posts;
    }

    public function generatePost()
    {
        $post = [
            'author' => array_rand(array_flip($this->authors)),
            'title' => $this->faker->sentence,
            'tags' => array_rand(array_flip($this->tags), rand(2, 6)),
            'rating' => $this->faker->numberBetween(-20, 20),
            'text' => $this->faker->realText($this->faker->numberBetween(200, 2000)),
            'date' => $this->getDate(),
        ];

        return $post;
    }

    /**
     * @return \MongoDB\BSON\UTCDateTime
     */
    public function getDate(): \MongoDB\BSON\UTCDateTime
    {
        return new \MongoDB\BSON\UTCDateTime($this->faker->dateTimeBetween('-2 years', 'now')->getTimestamp() * 1000);
    }

    /**
     * @return array
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }
}