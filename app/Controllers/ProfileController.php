<?php

namespace App\Controllers;

use App\DTO\AppConfigInterface;
use App\DTO\HttpStatus;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;

class ProfileController {

    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    #[ArrayShape(['data' => "array", 'code' => "int"])]
    public function index($id): array
    {
        return [
            'data' => [
                'id' => $id,
                'name' => 'Tony',
                'gender' => 'male',
            ],
            'code' => 200
        ];
    }

    /**
     * @throws GuzzleException
     * @throws DependencyException
     * @throws NotFoundException
     */
    #[ArrayShape(['data' => "array", 'code' => "int"])]
    public function postman(): array
    {
        $client = new Client();
        $appConfig = $this->container->get(AppConfigInterface::class);

        $res = $client->request($appConfig->getPostmanMethod(),
            $appConfig->getPostmanUri(),
            [
                'http_errors' => $appConfig->getPostmanDisableExceptions(),
                'headers' => [
                    'Authorization' => $appConfig->getPostmanAuthorizationToken()
            ]
        ]);

        $data =[];

        if ($res->getStatusCode() == HttpStatus::SUCCESS_CODE) {
            $data['success'] = true;
        }

        return [
          'data' => $data,
          'code' => $res->getStatusCode()
        ];
    }

}