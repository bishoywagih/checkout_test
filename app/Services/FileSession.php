<?php

namespace App\Services;

use App\Contracts\SessionManager;

class FileSession implements SessionManager
{
    public function get($key, $default = ''): mixed
    {
        if ($this->exists($key)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    public function set($key, $value = null): void
    {
        if (is_array($key)) {
            foreach ($key as $sessionKey => $sessionValue) {
                $_SESSION[$sessionKey] = $sessionValue;
            }
            return;
        }
        $_SESSION[$key] = $value;
    }

    public function exists($key): bool
    {
        return isset($_SESSION[$key]) && $_SESSION[$key];
    }

    public function clear(...$key)
    {
        foreach ($key as $sessionKey) {
            unset($_SESSION[$sessionKey]);
        }
    }
}
