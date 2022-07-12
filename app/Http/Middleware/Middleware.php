<?php

namespace App\Http\Middleware;

use App\Core\Request;

class Middleware
{
    protected string $uri;
    protected string $method;

    public function __construct()
    {
        $this->uri = Request::uri();
        $this->method = Request::method();
    }
}
