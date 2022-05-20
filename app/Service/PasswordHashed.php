<?php

namespace App\Service;

class PasswordHashed implements PasswordHashedInterface
{

    public function hashPassword(string $password): string
    {
        return password_hash($password, null);
    }

    public function checkPassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
}