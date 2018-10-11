<?php

namespace App\Helpers;


class PostProcessor
{
    public static function process($post)
    {
        $post['_id'] = (string)$post['_id'];
        $post['date'] = $post['date']->toDateTime()->getTimestamp();

        return $post;
    }
}