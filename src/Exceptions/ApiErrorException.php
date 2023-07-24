<?php

namespace AknEvrnky\PerfectPanel\Exceptions;

class ApiErrorException extends \Exception
{
    public function __construct($message = "Api Error", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}