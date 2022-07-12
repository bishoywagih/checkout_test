<?php

namespace App\Contracts;

interface CookieManager
{
    public function set($key, $value, int $minutes);
    public function get($key);
    public function exists($key): bool;
    public function clear($key);
    public function forever($key, $value);
}
