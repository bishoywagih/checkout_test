<?php

return [
    'mysql' => [
        'connection' => env('DB_CONNECTION', 'mysql'),
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_POST', '3306'),
        'name' => env('DB_NAME', 'check24'),
        'username' => env('DB_USER', 'root'),
        'password' => env('DB_PASSWORD', 'p@ssw0rd'),
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ],

    'test' => [
        'connection' => env('DB_CONNECTION', 'mysql'),
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_POST', '3306'),
        'name' => env('DB_NAME_TESTING', 'check24_testing'),
        'username' => env('DB_USER', 'root'),
        'password' => env('DB_PASSWORD', 'p@ssw0rd'),
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ],

];