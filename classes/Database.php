<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private $host;
    private $port;
    private $dbName;
    private $username;
    private $password;
    private $pdo;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->port = $_ENV['DB_PORT'];
        $this->dbName = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];

        try {
            $this->pdo = new PDO(
                "pgsql:host={$this->host};port={$this->port};dbname={$this->dbName}",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Returns the PDO connection.
     * @return PDO
     */
    public function getConnection()
    {
        return $this->pdo;
    }
}