<?php

require_once 'database/DBConnection.php';

dBTableSeeder('users_seeder', $dbConfig);

function dBTableSeeder($fileName, $dbConfig)
{
    $host = $dbConfig['host'];
    $user = $dbConfig['username'];
    $pass = $dbConfig['password'];
    $database = $dbConfig['name'];

    print "seeding $fileName table...\n";
    import(__DIR__ . "/{$fileName}.sql", $host, $database, $user, $pass);
    print "$fileName Seeded...\n";
}