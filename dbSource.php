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
    private string $database;
    private ?mysqli $conn;

    /**
     * Constructor,
     * provides resource: connection object
     */
    public function __construct(string $serverName, string $userName, string $password, string $database)
    {
        $this->serverName = $serverName;
        $this->userName = $userName;
        $this->password = $password;
        $this->database = $database;

        $this->connection();
    }

    private function connection(): void
    {
        $this->conn = new mysqli($this->serverName, $this->userName, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Database Connection Failed: " . $this->conn->connect_error);
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
