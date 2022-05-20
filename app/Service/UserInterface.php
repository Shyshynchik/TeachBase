<?php

namespace App\Service;

use App\Models\User as UserModel;

interface UserInterface
{
    public function createUser(string $name, string $email, string $password): void;

    public function getUser(string $email): ?UserModel;

    public function checkUser(UserModel $user): bool;

    public function getUserByToken(string $token): ?UserModel;

}