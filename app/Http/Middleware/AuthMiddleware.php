<?php

namespace App\Http\Middleware;

use App\Services\Auth;

class AuthMiddleware extends Middleware
{
    protected Auth $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
    }

    public function handle(array $protectedRoutes = [])
    {
        if (!auth()->check()) {
            if ($this->auth->hasRememberCookie()) {
                try {
                    $this->auth->setUserFromCookie();
                } catch (\Exception $exception) {
                    $this->auth->logout();
                }
            }
            if (in_array($this->uri, $protectedRoutes)) {
                return redirect('auth/login');
            }
        }
    }
}
