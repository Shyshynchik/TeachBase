<?php

return [
    '/api/v1/auth' => [
        'method' => ['POST'],
        'action' => 'AuthController@index',
    ],
    '/api/v1/logout' => [
        'method' => ['GET'],
        'action' => 'AuthController@logout',
        'middleware' => [
            'AuthMiddleWare'
        ],
    ],
    '/api/v1/profile' => [
        'method' => ['GET'],
        'action' => 'ProfileController@index',
        'middleware' => [
            'AuthMiddleWare'
        ],
    ],
    '/api/v1/postman/auth' => [
        'method' => ['GET'],
        'action' => 'ProfileController@postman',
        'middleware' => [
            'AuthMiddleWare'
        ],
    ],
    '/api/v1/register' => [
        'method' => ['POST'],
        'action' => 'RegistrationController@register'
    ]
];
