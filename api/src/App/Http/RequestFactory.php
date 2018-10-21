<?php

namespace App\Http;


class RequestFactory
{
    public static function createFromGlobals(array $server = null, array $query = null, array $body = null): Request
    {
        $request = new Request();

        $server = $server ?: $_SERVER;

        $url = self::makeUrl($server);
        $body = $body ?: $_POST;

        $parsedBody = $body ?: self::getParsedBody($body, $server);
        $request->setQueryParams($query ?: $_GET)
            ->setMethod($server['REQUEST_METHOD'] ?: 'GET')
            ->setUrl($url)
            ->setBody($parsedBody);


        return $request;
    }

    private static function makeUrl($server)
    {
        $url = '';
        $scheme = 'http';

        if ($server['REQUEST_SCHEME'] == 'https') {
            $scheme = 'https';
        }
        $url .= $scheme . ':';

        $host = $server['SERVER_NAME'] ?: '';
        if ($host) {
            $url .= '//' . $host;

            $port = $server['SERVER_PORT'] ?: '';
            if ($port) {
                $url .= ':' . $port;
            }
        }

        $path = $server['SCRIPT_NAME'];
        $url .= $path;

        $queryString = $server['QUERY_STRING'];
        if ($queryString) {
            $url .= '?' . $queryString;
        }

        return $url;
    }

    private static function getParsedBody($body, $server): array
    {
        if (!empty($body)) {
            return $body;
        }

        if (isset($server['HTTP_CONTENT_TYPE']) && stripos($server['HTTP_CONTENT_TYPE'], 'application/json') !== false) {
            return json_decode(file_get_contents('php://input'), true);
        }

        return [];
    }

}