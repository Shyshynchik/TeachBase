<?php

namespace App\Exception;

use Exception;
use Throwable;

class PageNotFoundException extends Exception
{
    private const ERROR_MESSAGE = "Not Found";

    public function __construct($message = self::ERROR_MESSAGE, $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}