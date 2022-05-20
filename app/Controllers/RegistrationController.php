<?php

namespace App\Controllers;

use App\Service\PasswordHashedInterface;
use App\Service\UserInterface;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Illuminate\Database\QueryException;
use JetBrains\PhpStorm\ArrayShape;

class RegistrationController
{
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

    #[ArrayShape(['data' => "bool[]", 'code' => "int"])]
    public function register(string $name, string $email, string $password): array
    {

        $hashedPassword = $this->passwordHash->hashPassword($password);

        try {

            $this->userService->createUser($name, $email, $hashedPassword);

            return [
                'data' => [
                    'success' => true,
                ],
                'code' => 200
            ];
        } catch (QueryException $e) {
            return [
                'data' => [
                    'info' => 'User already exists'
                ],
                'code' => 400
            ];
        }
    }
}