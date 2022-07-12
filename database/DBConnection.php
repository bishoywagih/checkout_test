<?php

require 'vendor/autoload.php';

$config = require_once 'config/db.php';

$dbConfig = $config['mysql'];
$host = $dbConfig['host'];
$dbname = $dbConfig['name'];
$user = $dbConfig['username'];
$pass = $dbConfig['password'];

function import($file, $host , $dbname, $user, $pass) {
    exec("mysql " . ($pass ? "-p$pass " : '') . "-h $host -u $user -D $dbname < $file", $output, $return);
    if ($return) die("import SQL file was not imported\n");
}