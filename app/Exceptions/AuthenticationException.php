<?php

namespace App\Exceptions;

class AuthenticationException extends \Exception
{
    public function __construct($uri, array $inputs, array $errors)
    {
        $this->uri = $uri;
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
