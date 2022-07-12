<?php

namespace App\Http\Middleware;

use App\Exceptions\CsrfTokenException;

class CsrfMiddleware extends Middleware
{
    /**
     * @throws CsrfTokenException
     */
    public function handle()
    {
        if ($this->method === 'POST') {
            if ($_POST['_token'] !== $_SESSION['_token']) {
                throw new CsrfTokenException('Invalid csrf token');
            }
        }
    }
}
