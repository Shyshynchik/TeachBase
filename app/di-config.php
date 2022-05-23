<?php

use App\Components\MailerInterface;
use App\Components\Mailer;
use App\Components\ManagerInterface;
use App\Components\UserManager;
use App\DTO\AppConfig;
use App\Jwt\Jwt;
use App\Jwt\JwtInterface;
use App\Service\PasswordHashed;
use App\Service\PasswordHashedInterface;
use App\Service\User;
use App\DTO\AppConfigInterface;

use App\Service\UserInterface;
use function DI\create;
use function DI\get;

$config = include "app_config.php";

return [
    MailerInterface::class => get(Mailer::class),
    ManagerInterface::class => get(UserManager::class),
    AppConfigInterface::class => create(AppConfig::class)->constructor($config),
    UserInterface::class => get(User::class),
    PasswordHashedInterface::class => get(PasswordHashed::class),
    JwtInterface::class => create(Jwt::class)->constructor($_ENV['TOKEN_KEY'], $_ENV['TOKEN_ALG']),
];
