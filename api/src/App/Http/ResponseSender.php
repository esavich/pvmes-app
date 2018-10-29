<?php

namespace App\Http;

class ResponseSender
{
    public static function send(Response $response): void
    {
        header('HTTP/1.1 ' . $response->getStatusCode() . ' ' . $response->getStatusText());
        foreach ($response->getHeaders() as $name => $value) {
            header($name . ':' . $value);
        }
        echo $response->getBody();
    }
}
