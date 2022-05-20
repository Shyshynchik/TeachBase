<?php

namespace App\DTO;

interface AppConfigInterface
{
    public function getToken(string $type): ?string;

    public function getPostmanConfig(string $key): array;

    public function getPostmanMethod(): string;

    public function getPostmanUri(): string;

    public function getPostmanDisableExceptions(): string;

    public function getPostmanAuthorizationToken(): string;

    public function getPostmanSuccessResult(): array;

}