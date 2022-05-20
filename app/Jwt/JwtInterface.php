<?php

namespace App\Jwt;

use App\Models\User as UserModel;
use App\Service\User;

interface JwtInterface
{

    public function isActive(string $token): bool;

    public function getDataFromToken(string $token): ?UserModel;

    public function setTokens(UserModel $user): string;
}