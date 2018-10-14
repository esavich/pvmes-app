<?php

namespace App\Helpers;


class CommentProcessor
{
    public static function process($post)
    {
        $post['_id'] = (string)$post['_id'];
        $post['date'] = (int)(string)$post['date'];
        $post['comment'] = nl2br($post['comment']);
        $post['gravatarUri'] = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($post['email']))) . "?s=32";

        return $post;
    }
}