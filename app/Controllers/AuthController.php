<?php

namespace App\Controllers;

use App\Jwt\JwtInterface;
use App\Service\PasswordHashedInterface;
use App\Service\UserInterface;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use JetBrains\PhpStorm\ArrayShape;

class AuthController {

    private Container $container;

    private UserInterface $userService;

    private PasswordHashedInterface $passwordHash;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->userService = $this->container->get(UserInterface::class);

        $this->passwordHash = $this->container->get(PasswordHashedInterface::class);
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    #[ArrayShape(['data' => "string[]", 'code' => "int"])]
    public function index(string $email, string $password): array
    {

        $user = $this->userService->getUser($email);

        if ($user && $this->passwordHash->checkPassword($password, $user->password)) {

            $jwt = $this->container->get(JwtInterface::class);

            $token = $jwt->setTokens($user);

            return [
                'data' => [
                    'token' => $token,
                ],
                'code' => 200
            ];
        }

        return [
            'data' => [
                'info' => 'Incorrect login or password'
            ],
            'code' => 400
        ];
    }

    #[ArrayShape(['data' => "bool[]", 'code' => "int"])]
    public function logout(): array
    {
        return [
            'data' => [
                'success' => true,
            ],
            'code' => 200
        ];
    }
}
