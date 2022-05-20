<?php

namespace App\DTO;

class ResultResponse
{
    private array $result;
    private int $responseCode;
    private string $responseMessage;

    public function __construct(int $responseCode, string $responseMessage, array $result)
    {
        $this->result = $result;
        $this->responseCode = $responseCode;
        $this->responseMessage = $responseMessage;
    }

    public function getResult(): array
    {
        return $this->result;
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    public function getResponseMessage(): string
    {
        return $this->responseMessage;
    }
}