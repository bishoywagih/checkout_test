<?php

namespace App\Contracts;

interface SessionManager
{
    public function get($key, $default = ''): mixed;
    public function set($key, $value = null): void;
    public function exists($key): bool;
    public function clear($key);
}
