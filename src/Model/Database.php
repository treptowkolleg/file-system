<?php

namespace App\Model;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    private PDO $pdo;
    private PDOStatement $statement;
    private string $host;
    private string $database;
    private string $username;
    private string $password;
    public function __construct(string $host, string $username, string $password, string $database)
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->connect();
    }

    private function connect(): void
    {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->database}",
                $this->username, $this->password
            );
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    private function execute(): void
    {
        $this->statement->execute();
    }

    public function setQuery(string $query, array $parameters = null): Database
    {
        $this->statement = $this->pdo->prepare($query);

        if($parameters !== null){
            foreach ($parameters as $param => $value) {
                $this->statement->bindValue($param, $value);
            }
        }
        return $this;
    }

    public function fetchAll(int $mode = PDO::FETCH_ASSOC, string $class = null): array
    {
        $this->execute();
        return match ($mode) {
            // assoziatives Array
            PDO::FETCH_ASSOC => $this->statement->fetchAll(PDO::FETCH_ASSOC),
            // Array mit Nummern als Key
            PDO::FETCH_NUM => $this->statement->fetchAll(PDO::FETCH_NUM),
            // Sowohl ASSOC als auch NUM
            PDO::FETCH_BOTH => $this->statement->fetchAll(PDO::FETCH_BOTH),
            // Array mit Objekten (siehe Parameter $class)
            PDO::FETCH_OBJ => $this->statement->fetchAll(PDO::FETCH_CLASS, $class),
        };
    }

}
