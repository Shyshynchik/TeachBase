<?php

namespace App\DTO;

class HttpStatus
{
    public const HTTP_VERSION = "HTTP/1.1";

    public const SUCCESS_CODE = 200;
    public const NOT_FOUND_CODE = 404;
    public const INTERNAL_SERVER_ERROR_CODE = 500;

    public const SUCCESS_MESSAGE = 'OK';
    public const NOT_FOUND_MESSAGE = 'Not Found';
    public const INTERNAL_SERVER_ERROR_MESSAGE = 'Internal Server Error';

    public static function getHeaderMessage(int $code, string $message): string
    {
        return self::HTTP_VERSION . " " . $code . " " . $message;
    }

}