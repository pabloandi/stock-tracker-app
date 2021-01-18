<?php

namespace App\Exceptions;

use Exception;

class RetailerClientException extends Exception
{
    public function __construct(...$args) {
        parent::__construct(...$args);
    }
}
