<?php

namespace App\Models;

use App\Core\App;
use PDO;

abstract class Model
{
    protected string $table;
    protected PDO $db;
    protected App $app;
    public function __construct()
    {
        $this->app = new App();
        $this->db = $this->app->get('database');
    }

    public function create(array $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $this->table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute($parameters);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function update(array $parameters)
    {
        $data = null;
        $iteration = 0;
        foreach ($parameters as $key => $value) {
            $iteration++;
            $data .= $key . "=" . "'$value'";
            if ($iteration !== count($parameters)) {
                $data .=  ',';
            }
        }
        try {
            $sql = "update $this->table set $data where id = :id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $this->id, PDO::PARAM_INT);
            $statement->execute();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Select all records from a database table.
     *
     */
    public function selectAll(): bool|array
    {
        $statement = $this->db->prepare("select * from {$this->table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function find(array $criteria, $operator = 'AND')
    {
        $statement = $this->selectQueryBuilder($criteria, $operator);
        return $statement->fetch();
    }

    public function select(array $criteria, $operator = 'AND'): bool|array
    {
        $statement = $this->selectQueryBuilder($criteria, $operator);
        return $statement->fetchAll();
    }

    protected function selectQueryBuilder(array $criteria, $operator = 'AND'): bool|\PDOStatement
    {
        $statement = $this->getSelectStatement($criteria, $operator);
        $statement->setFetchMode(PDO::FETCH_CLASS, User::class);
        $statement->execute();
        return $statement;
    }

    protected function getSelectStatement(array $criteria = [], $operator = 'AND'): bool|\PDOStatement
    {
        if (count($criteria) > 0) {
            $iteration = 0;
            $criteriaCount = count($criteria);
            $conditions = '';
            foreach ($criteria as $key => $value) {
                $iteration++;
                $conditions .= "$key='$value'";
                if ($criteriaCount !== $iteration) {
                    $conditions .= ' ' . $operator . ' ';
                }
            }
            $statement = $this->db->prepare("select * from {$this->table} where $conditions");
        } else {
            $statement = $this->db->prepare("select * from {$this->table}");
        }
        return $statement;
    }

    public function count()
    {
        $sql = "select count(*) from $this->table";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchColumn();
    }
}
