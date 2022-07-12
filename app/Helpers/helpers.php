<?php

if (! function_exists('env')) {
    function env($key, $default = '')
    {
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }
        return $default;
    }
}

if (! function_exists('base_path')) {
    function base_path($path): string
    {
        return __DIR__.'/../../' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (! function_exists('view')) {
    function view($name, $data = [])
    {
        extract($data);
        return require_once base_path('resources/views/' . $name . '.php');
    }
}

/**
 * Redirect to a new page.
 *
 * @param  string $path
 */
if (! function_exists('redirect')) {
    function redirect($path)
    {
        header("Location: /{$path}");
    }
}

/**
 * Redirect to a new page.
 *
 * @param  string $path
 */
if (! function_exists('auth')) {
    function auth(): \App\Services\Auth
    {
        return new \App\Services\Auth();
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['_token'] = $token;
        return $token;
    }
}
