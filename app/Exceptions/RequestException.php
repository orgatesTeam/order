<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\Validator;

class RequestException extends Exception
{
    public function __construct($messages)
    {
        // some code

        // make sure everything is assigned properly
        parent::__construct($messages, 502);
    }

    // custom string representation of object
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
