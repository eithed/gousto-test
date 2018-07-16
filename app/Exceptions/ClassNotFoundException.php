<?php

namespace App\Exceptions;

use Throwable;

class ClassNotFoundException extends \Exception
{
    public function __construct(
        $message = "Class not found",
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
