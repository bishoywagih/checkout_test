<?php

session_start();

use App\Config\Config;
use App\Core\{App, Database\Connection, Request, Router};
use App\Http\Middleware\Middleware;

/**
 * read environment variables from .env file
 */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..//');
$dotenv->load();

/**
 * load the configuration files.
 */
$config = (new Config())->load([
    'app' => base_path('config/app.php'),
    'db' => base_path('config/db.php'),
]);
App::bind('config', $config);

/**
 * init the database connection.
 */
$connection = (new Connection())->make();
App::bind('database', $connection);

/**
 * binding Session Manage
 */
App::bind(\App\Contracts\SessionManager::class, new \App\Services\FileSession());

/**
 * binding Hasher to container.
 */
App::bind(\App\Contracts\Hash::class, new \App\Services\BCryptHash());

/**
 * load app routes.
 */
try {
    $middleware = new Middleware();
    //register middleware for csrf.
    Router::load(base_path('routes/web.php'))
        ->direct(Request::uri(), Request::method());
    App::get(\App\Contracts\SessionManager::class)->clear('errors', 'old');
}
catch (Exception $exception){
    $handler = new \App\Exceptions\Handler(
        $exception,
    );
    $response = $handler->respond();
}