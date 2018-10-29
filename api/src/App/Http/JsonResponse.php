<?php


namespace App\Http;

class JsonResponse extends Response
{

    /**
     * Response constructor.
     * @param $body
     * @param int $statusCode
     * @param string $statusText
     */
    public function __construct($body, $statusCode = 200, $statusText = 'OK')
    {
        parent::__construct($body, $statusCode, $statusText);
        $this->addHeader('Content-Type', 'application/json');
    }

    public function getBody()
    {
        return json_encode($this->body);
    }
}
