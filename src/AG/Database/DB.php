<?php

namespace AG\Database;


class DB
{
    private $pdo;

    public function __construct($dns, $username, $password)
    {
        try {
            $this->pdo = new \PDO($dns, $username, $password);
        } catch(\PDOException $e) {
            echo $e->getMessage()."\n";
            echo $e->getTraceAsString()."\n";

            die;
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}