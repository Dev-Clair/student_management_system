<?php

/**
 * Database Connection Class.
 * Establishes Connection
 * and Provides Resource for Database Operations.
 */
class DbConnection
{
    private string $serverName;
    private string $userName;
    private string $password;
    private ?string $database;
    private ?mysqli $conn;

    /**
     * Constructor,
     * provides resource: connection object
     */
    public function __construct(string $serverName, string $userName, string $password)
    {
        $this->serverName = $serverName;
        $this->userName = $userName;
        $this->password = $password;
        $this->database = null;
        $this->connection();
    }

    public function setDatabase(?string $database)
    {
        $this->database = $database;
    }

    public function getDatabase(): ?string
    {
        return $this->database;
    }

    private function connection(): void
    {
        $database = $this->getDatabase();
        if ($database === null) {
            $this->conn = new mysqli($this->serverName, $this->userName, $this->password);
        } else {
            $this->conn = new mysqli($this->serverName, $this->userName, $this->password, $database);
        }

        if ($this->conn->connect_error) {
            die("Error! Connection Failed: " . $this->conn->connect_error);
        }
    }


    public function getConnection(): ?mysqli
    {
        return $this->conn;
    }

    /**
     * Destructor,
     * closes resource: connection object
     */
    public function __destruct()
    {
        if ($this->conn !== null) {
            $this->conn->close();
        }
    }
}
