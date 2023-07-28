<?php

class DbConnection
{
    private string $serverName;
    private string $userName;
    private string $password;
    private ?string $database;
    private ?mysqli $conn;

    /**
     * Constructor, initializes the connection settings.
     *
     * @param string $serverName Server name (localhost) or IP address(remote host).
     * @param string $userName   Database username.
     * @param string $password   Database password.
     * @param string|null $database   Database name (optional).
     */
    public function __construct(string $serverName, string $userName, string $password, ?string $database = null)
    {
        $this->serverName = $serverName;
        $this->userName = $userName;
        $this->password = $password;
        $this->database = $database;
        $this->connect();
    }

    /**
     * Establishes resource: the database connection.
     */
    private function connect(): void
    {
        $this->conn = new mysqli($this->serverName, $this->userName, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Error! Connection Failed: " . $this->conn->connect_error);
        }
    }

    /**
     * Retrieves resource: database connection object.
     * @return mysqli|null Database connection object.
     */
    public function getConnection(): ?mysqli
    {
        return $this->conn;
    }

    /**
     * Closes the resource: database connection.
     */
    public function closeConnection(): void
    {
        if ($this->conn !== null) {
            $this->conn->close();
        }
    }
}
