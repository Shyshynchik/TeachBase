<?php

namespace App\DTO;

class AppConfig implements AppConfigInterface
{
    private array $appConfig;

    public function __construct(array $appConfig)
    {
        $this->appConfig = $appConfig;
    }

    public function getToken(string $type): ?string
    {
        return $this->appConfig[$type];
    }

    public function getPostmanConfig(string $key): array
    {
        return $this->appConfig[$key]['method'];
    }

    public function getPostmanMethod(): string
    {
        return $this->appConfig['postman']['method'];
    }

    public function getPostmanUri(): string
    {
        return $this->appConfig['postman']['uri'];
    }

    public function getPostmanDisableExceptions(): string
    {
        return $this->appConfig['postman']['disable_exceptions'];
    }

    public function getPostmanAuthorizationToken(): string
    {
        return $this->appConfig['postman']['authorization_token'];
    }

    public function getPostmanSuccessResult(): array
    {
        return $this->appConfig['postman']['success_result'];
    }
}