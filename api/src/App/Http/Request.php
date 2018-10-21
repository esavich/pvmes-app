<?php

namespace App\Http;


/**
 * Class Request
 * @package App\Http
 */
class Request
{
    /**
     * @var array
     */
    private $queryParams = [];
    /**
     * @var array
     */
    private $body;
    /**
     * @var string
     */
    private $method = 'GET';
    /**
     * @var array
     */
    private $url = [];
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * Request constructor.
     * @param array $queryParams
     * @param array $body
     * @param string $url
     */
    public function __construct($queryParams = [], $body = [], $url = '')
    {
        $this->queryParams = $queryParams;
        $this->body = $body;
        $this->url = parse_url($url) ?: [];
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @param array $queryParams
     * @return Request
     */
    public function setQueryParams(array $queryParams): Request
    {
        $this->queryParams = $queryParams;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return Request
     */
    public function setMethod(string $method): Request
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @param array $body
     * @return Request
     */
    public function setBody(array $body): Request
    {
        $this->body = $body;
        return $this;
    }


    /**
     * @param $key
     * @param string $default
     * @return null|string
     */
    public function getUrlPart($key, string $default = null): ?string
    {
        return $this->url[$key] ?? $default;
    }

    /**
     * @return array
     */
    public function getUrl(): array
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Request
     */
    public function setUrl(string $url): Request
    {
        $this->url = parse_url($url);
        return $this;
    }

    /**
     * @param $key
     * @param $val
     * @return Request
     */
    public function addAttribute($key, $val): Request
    {
        $this->attributes[$key] = $val;
        return $this;
    }

    /**
     * @param $key
     * @return Request
     */
    public function removeAttribute($key): Request
    {
        if (isset($this->attributes[$key])) {
            unset($this->attributes[$key]);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return Request
     */
    public function setAttributes(array $attributes): Request
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function getAttribute($key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function getParam($key, $default = null)
    {
        return $this->queryParams[$key] ?? $default;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function getPost($key, $default = null)
    {
        return $this->body[$key] ?? $default;
    }
}