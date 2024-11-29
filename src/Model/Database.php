<?php

namespace App\Model;

use PDO;
use PDOException;
use PDOStatement;
use ReflectionClass;
use ReflectionException;

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
            $this->pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
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

    public function fetchAllAsObject(string $class): array
    {
        try {
            $refClass = new ReflectionClass($class);
            $columns = [];

            foreach ($refClass->getProperties() as $property) {
                $columns[] = strtolower($property->getName()) . " AS " . $property->getName();
            }

            $query = "SELECT " . implode(", ", $columns) . " FROM " . strtolower($refClass->getShortName());
            $this->setQuery($query)->execute();

            return $this->statement->fetchAll(PDO::FETCH_CLASS, $class);
        } catch (ReflectionException $e) {
            exit($e->getMessage());
        }
    }

}
