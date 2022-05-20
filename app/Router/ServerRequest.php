<?php

namespace App\Router;

class ServerRequest
{
    private string $path;
    private string $method;
    private array $params;

    public function __construct(string $path, string $method, array $params)
    {
        $this->path = $path;
        $this->method = $method;
        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

}