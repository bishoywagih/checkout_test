<?php

namespace App\Services;

use App\Contracts\CookieManager;

class Cookie implements CookieManager
{
    protected string $path = '/';
    protected string $domain = '';
    protected bool $secure = false;
    protected bool $httpOnly = true;


    public function set($key, $value, int $minutes = 60)
    {
        $expiry = time() + $minutes * 60;

        setcookie($key, $value, $expiry, $this->path, $this->domain, $this->secure, $this->httpOnly);
    }

    public function get($key, $default = '')
    {
        if ($this->exists($key)) {
            return $_COOKIE[$key];
        }
        return $default;
    }

    public function exists($key): bool
    {
        return isset($_COOKIE[$key]) && $_COOKIE[$key];
    }

    public function clear($key)
    {
        $this->set($key, null, -2628000, $this->path, $this->domain);
    }

    public function forever($key, $value)
    {
        $this->set($key, $value, 2628000);
    }
}
