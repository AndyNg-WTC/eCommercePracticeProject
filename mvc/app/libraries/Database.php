<?php

declare(strict_types=1);

namespace libraries;

use PDO;

/**
 * PDO Database Class
 * Connect to database
 * Create prepared statements
 * Bind values
 * Return rows and results
 */
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;

    private $dbh;   # Database handler
    private $stmt;
    private $error;

    public function __construct()
    {
        //set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;
        $options = array(
            PDO::ATTR_PERSISTENT => true,   # checks to see if a connection has been established with the DB
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION     # Elegant way to handle exceptions
        );

        // Create PDO instance

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();

            echo $this->error;
        }
    }

    // Prepare statement with query
    public function query($sql): void
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind values
    public function bind($param, $value, $type = null): void
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute(): bool
    {
        return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function resultSet(): array
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);   # Return results as an Object not array
    }

    // Get single record as object
    public function single(): \stdClass|bool
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count
    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }
}
