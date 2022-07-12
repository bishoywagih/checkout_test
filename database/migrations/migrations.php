<?php

require_once 'database/DBConnection.php';

dropDb($dbConfig);
migrate($dbConfig);

function migrate($dbConfig)
{
//    dbConnection($dbConfig);
    createTable('users', $dbConfig);
    createTable('blogs', $dbConfig);
}

function dbConnection($dbConfig)
{
    $host = $dbConfig['host'];
    $user = $dbConfig['username'];
    $pass = $dbConfig['password'];
    $database = $dbConfig['name'];

    $str ="mysql -u$user -p$pass -h$host $database";
    exec($str, $output, $return);
    if ($return) die("Table users was not created\n");
}

function createTable($tableName, $dbConfig)
{
    $host = $dbConfig['host'];
    $user = $dbConfig['username'];
    $pass = $dbConfig['password'];
    $database = $dbConfig['name'];

    print "Creating $tableName table...\n";
    import(__DIR__ . "/{$tableName}.sql", $host, $database, $user, $pass);
    print "$tableName table Created...\n";
}

function dropDb($dbConfig)
{
    $host = $dbConfig['host'];
    $user = $dbConfig['username'];
    $pass = $dbConfig['password'];
    $dbname = $dbConfig['name'];

    $str = "mysql -h$host -u$user " . ($pass ? "-p$pass" : '') . " -e 'drop database if exists $dbname'";
    exec($str, $output, $return);
    if ($return) die("Can't Drop Database d\n");

    createDB($dbConfig);
}

function createDB($dbConfig)
{
    $host = $dbConfig['host'];
    $user = $dbConfig['username'];
    $pass = $dbConfig['password'];
    $dbname = $dbConfig['name'];

    $str = "mysql -h$host -u$user " . ($pass ? "-p$pass" : '') . " -e 'create database if not exists $dbname'";
    exec($str, $output, $return);
    if ($return) die("Can't Create Database d\n");
}