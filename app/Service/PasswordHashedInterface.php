<?php

namespace App\Service;

interface PasswordHashedInterface
{
    public function hashPassword(string $password): string;

    public function checkPassword(string $password, string $hashedPassword): bool;
}