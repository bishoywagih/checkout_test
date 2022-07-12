<?php

namespace App\Exceptions;

use App\Core\Request;
use Exception;

class ValidationException extends Exception
{
    public function __construct(array $inputs, array $errors)
    {
        $this->uri = Request::uri();
        $this->inputs = $inputs;
        $this->errors = $errors;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getOldInput(): array
    {
        return $this->inputs;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
