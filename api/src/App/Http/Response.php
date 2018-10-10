<?php

namespace App\Http;


class Response
{
    const STATUS = [
        200 => 'OK',
        201 => 'Created',
        301 => 'Moved Permanently',
        302 => 'Moved Temporarily',
        400 => 'Bad Request',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
    ];

    protected $body;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $statusText;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * Response constructor.
     * @param $body
     * @param int $statusCode
     * @param string $statusText
     */
    public function __construct($body, $statusCode = 200, $statusText = 'OK')
    {

        $this->body = $body;
        $this->statusCode = $statusCode;
        $this->statusText = $statusText;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Response
     */
    public function setBody($body): Response
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param int $status
     * @param string $statusText
     * @return Response
     */
    public function setStatus(int $status, string $statusText = ''): Response
    {
        $this->statusCode = $status;
        $this->statusText = $statusText;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusText(): string
    {
        if (!$this->statusText && self::STATUS[$this->getStatusCode()]) {
            $this->statusText = self::STATUS[$this->getStatusCode()];
        }
        return $this->statusText;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader($key)
    {
        return $this->headers[$key] ?? null;
    }

    /**
     * @param $key
     * @param $value
     * @return Response
     */
    public function addHeader($key, $value): Response
    {
        if (isset($this->headers[$key])) {
            unset($this->headers[$key]);
        }

        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * @param $key
     * @return Response
     */
    public function removeHeader($key): Response
    {
        if (isset($this->headers[$key])) {
            unset($this->headers[$key]);
        }

        return $this;
    }
}