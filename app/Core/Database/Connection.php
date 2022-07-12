<?php

namespace App\Core\Database;

use App\Core\App;
use PDO;
use PDOException;

class Connection
{
    protected App $app;

    public function __construct()
    {
        $this->app = new App();
    }

    public function make()
    {
        $config = $this->getDbConnection();
        try {
            return new PDO(
                $config['connection'].":host=".$config['host'].";dbname=".$config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    protected function getDbConnection()
    {
        $environment = $this->app->get('config')->get('app')['environment'];
        $dbConfig = $this->app->get('config')->get('db');
        if ($environment === 'testing') {
            $dbConfig = $dbConfig['test'];
        } else {
            $dbConfig = $dbConfig['mysql'];
        }
        return $dbConfig;
    }
}
