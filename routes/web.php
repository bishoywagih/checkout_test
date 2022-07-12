<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BlogController;

$router->get('/blog/{id}', [BlogController::class, 'show']);
$router->get('/auth/register', [AuthController::class, 'register']);
$router->post('/auth/register', [AuthController::class, 'userRegistration']);
$router->get('/auth/login', [AuthController::class, 'login']);
$router->post('/auth/login', [AuthController::class, 'authenticate']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/blog', [BlogController::class, 'index']);

$router->get('/blog/create', [BlogController::class, 'create']);
$router->post('/blog', [BlogController::class, 'store']);

$router->get('', [\App\Http\Controllers\HomeController::class, 'index']);

