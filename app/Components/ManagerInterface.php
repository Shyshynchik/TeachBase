<?php

namespace App\Components;

interface ManagerInterface
{
    public function register(string $email, string $password): void;
}