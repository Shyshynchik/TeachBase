<?php

namespace App\Jwt;

use App\Models\User as UserModel;
use App\Service\User;
use Exception;
use Firebase\JWT\JWT as JWTLib;
use Firebase\JWT\Key;

class Jwt implements JwtInterface
{
    private string $alg;
    private string $activeKey;

    public function __construct(string $key, string $alg)
    {
        $this->activeKey = $key;
        $this->alg = $alg;
    }

    private function createToken(UserModel $user): string
    {
        $payload = [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'exp' => strtotime('+1 week'),
        ];

        return JWTLib::encode($payload, $this->activeKey, $this->alg);
    }

    private function createRefreshToken(): string
    {
        $payload = [
            'exp' => strtotime('+4 week')
        ];

        return JWTLib::encode($payload, $this->activeKey, $this->alg);
    }

    public function isActive(string $token): bool
    {
        try {
            $decodedPayload = $this->decode($token);
        } catch (Exception $e) {
            return false;
        }

        if (array_key_exists('exp', $decodedPayload) && $decodedPayload['exp'] > time()) {
            return true;
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public function getDataFromToken(string $token): ?UserModel
    {
        $decodedToken = $this->decode($token);

        $keys = ['email', 'id', 'name'];

        if ($this->checkKeys($keys, $decodedToken)) {
            $user = new UserModel();
            $user->email = $decodedToken['email'];
            $user->token = $token;
            $user->id = $decodedToken['id'];
            $user->name = $decodedToken['name'];

            return $user;
        }

        return null;
    }

    /**
     * @throws Exception
     */
    private function decode($token): array
    {
        $decodedToken = JWTLib::decode($token, new Key($this->activeKey, $this->alg));

        return (array)$decodedToken;
    }

    private function checkKeys(array $keys, array $decodedToken): bool
    {
        $result = array_diff_key(array_flip($keys), $decodedToken);

        if (!$result) {
            return true;
        }

        return false;
    }

    public function setTokens(UserModel $user): string
    {
        $user->token = $this->createToken($user);

        $user->refresh_token = $this->createRefreshToken();

        $user->save();

        return $user->token;
    }
}