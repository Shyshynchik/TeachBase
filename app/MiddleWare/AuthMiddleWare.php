<?php

namespace App\MiddleWare;

use App\Jwt\JwtInterface;
use App\Service\UserInterface;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleWare
{

    private Container $container;

    private JwtInterface $jwt;

    private UserInterface $userService;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->jwt = $this->container->get(JwtInterface::class);

        $this->userService = $this->container->get(UserInterface::class);
    }

    public function __invoke(Request $request, Response $response, $next): Response
    {
        $token = $request->getHeaderLine('Token');

        if ($this->jwt->isActive($token) && $this->checkTokenData($token)) {
            return $next($request, $response);
        }

        $newToken = $this->checkRefreshToken($token);

        if ($newToken) {

            $response->getBody()->write(json_encode(['token' => $newToken]));

            return $next($request, $response);
        }

        return $response->withStatus(401);

    }

    private function checkTokenData(string $token): bool
    {
        $user = $this->jwt->getDataFromToken($token);

        return $user && $this->userService->checkUser($user);
    }

    private function checkRefreshToken(string $token): ?string
    {
        $user = $this->userService->getUserByToken($token);

        if ($user && $this->jwt->isActive($user->refresh_token)) {

            return $this->jwt->setTokens($user);
        }

        return null;
    }

}