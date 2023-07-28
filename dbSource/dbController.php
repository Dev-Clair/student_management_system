<?php

/**
 * Table Creation Class.
 * Requires Resource
 * to Create Tables in Database.
 */
class DbTable
{
    private ?mysqli $conn;

    /**
     * Constructor,
     * sources resource: connection object
     */
    public function __construct(?mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * @param string $tableName = "Name of table to be created in database"
     * @param string $fieldNames = "fieldName dataType NULL/NOT NULL ?PRIMARY KEY ?AUTO_INCREMENT, fieldName dataType NULL/NOT NULL ?DEFAULT"
     * @return bool True if the table was created successfully, false otherwise
     */
    public function createTable(string $tableName, string $fieldNames): bool
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $sql_query = "CREATE TABLE IF NOT EXISTS $tableName ($fieldNames)";
        $result = $this->conn->query($sql_query);

        if ($result !== true) {
            throw new Exception("Error! Table Creation Failed: " . $this->conn->error);
        }

        // $this->conn->close(); // Close Connection Object
        return $result === true;
    }

    /**
     * @param string $tableName Name of the table to be altered in the database
     * @param string $alterStatement Statement to modify the table structure
     * @return bool True if the table was altered successfully, false otherwise
     */
    public function alterTable(string $tableName, string $alterStatement): bool
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $sql_query = "ALTER TABLE $tableName $alterStatement";
        $result = $this->conn->query($sql_query);

        if ($result !== true) {
            throw new Exception("Error! Process Failed: " . $this->conn->error);
        }

        // $this->conn->close(); // Close Connection Object
        return $result === true;
    }

    /**
     * @param string $tableName Name of the table to be truncated in the database
     * @return bool True if the table was truncated successfully, false otherwise
     */
    public function truncateTable(string $tableName): bool
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $sql_query = "TRUNCATE TABLE $tableName";
        $result = $this->conn->query($sql_query);

        if ($result !== true) {
            throw new Exception("Error! Process Failed: " . $this->conn->error);
        }

        // $this->conn->close(); // Close Connection Object
        return $result === true;
    }

    /**
     * @param string $tableName Name of the table to be dropped in the database
     * @return bool True if the table was dropped successfully, false otherwise
     */
    public function dropTable(string $tableName): bool
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $sql_query = "DROP TABLE $tableName";
        $result = $this->conn->query($sql_query);

        if ($result !== true) {
            throw new Exception("Error! Process Failed: " . $this->conn->error);
        }

        // $this->conn->close(); // Close Connection Object
        return $result === true;
    }

    /**
     * Retrieves the names of tables in a database as an array containing values only.
     * @param string $databaseName Name of the database
     * @return array Array containing the names of tables
     */
    public function retrieveTableNames(string $databaseName): array
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $sql_query = "SHOW TABLES FROM $databaseName";
        $result = $this->conn->query($sql_query);

        if ($result) {
            $tableNames = [];
            while ($row = $result->fetch_row()) {
                $tableNames[] = $row[0];
            }
            $result->close(); // Close Result Object
            return $tableNames;
        }
        // $this->conn->close(); // Close connection
        return [];
    }
}

/*
 * Table Read and Write Class.
 * Requires Resource
 * to Execute Various Table Read and Write Operations.
 */
class DbTableOps
{
    private ?mysqli $conn;

    /**
     * Constructor,
     * sources resource: connection object
     */
    public function __construct(?mysqli $conn)
    {
        $this->conn = $conn;
    }

    private function getBindParamTypes(array $values): string
    {
        $types = "";
        foreach ($values as $value) {
            if (is_int($value)) {
                $types .= "i"; // Integer
            } elseif (is_float($value)) {
                $types .= "d"; // Double
            } elseif (is_string($value)) {
                $types .= "s"; // String
            } else {
                $types .= "b"; // Blob
            }
        }
        return $types;
    }

    private function getColumnNames(string $tableName): array
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $columnNames = [];

        $sql_query = "SELECT * FROM $tableName LIMIT 1";

        $result = $this->conn->query($sql_query);

        if ($result) {
            $fields = $result->fetch_fields();
            foreach ($fields as $field) {
                $columnNames[] = $field->name;
            }
        } else {
            return [];
        }

        // $this->conn->close(); // Close Connection Object
        return $columnNames;
    }

    /**
     * @param string $tableName = "Name of table created with the createTable function"
     * @param array $sanitizedData = ["fieldName" => $fieldValue, "fieldName" => $fieldValue, "fieldName" => $fieldValue, ...]
     */
    public function createRecords(string $tableName, array $sanitizedData): bool
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $columns = implode(",", array_map(function ($column) {
            return "`$column`";
        }, array_keys($sanitizedData)));

        $placeholders = implode(",", array_fill(0, count($sanitizedData), "?"));
        $types = $this->getBindParamTypes($sanitizedData);
        $sql_query = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";

        $stmt = $this->conn->prepare($sql_query);

        if (!$stmt) {
            throw new Exception("Error in prepared statement: " . $this->conn->error);
        }

        $stmt->bind_param($types, ...array_values($sanitizedData));
        $status = $stmt->execute();

        if ($status === false) {
            throw new Exception("Error executing statement: " . $stmt->error);
        }

        $stmt->close(); // Close statement
        // $this->conn->close(); // Close Connection Object

        return $status;
    }

    public function validateRecord(string $tableName, $fieldName, $fieldValue): bool
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $paramTypes = $this->getBindParamTypes([$fieldValue]);
        $sql_query = "SELECT * FROM $tableName WHERE $fieldName = ?";

        $stmt = $this->conn->prepare($sql_query);

        if (!$stmt) {
            throw new Exception("Error in prepared statement: " . $this->conn->error);
        }

        $stmt->bind_param($paramTypes, $fieldValue);
        $stmt->execute();
        $result = $stmt->get_result();

        $validFieldValue = $result->num_rows > 0;

        $stmt->close(); // Close statement

        return $validFieldValue;
    }

    public function retrieveAllRecords(string $tableName): array
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $sql_query = "SELECT * FROM $tableName";
        $result = $this->conn->query($sql_query);

        if ($result->num_rows > 0) {
            $rows = $result->fetch_all(MYSQLI_ASSOC); // Returns an associative array
            $result->close(); // Close Result Object

            // $this->conn->close(); // Close Connection Object
            return $rows;
        }

        // $this->conn->close(); // Close Connection Object
        return [];
    }

    /**
     * retrieve a single value from a specific field
     */
    public function retrieveSingleValue(string $tableName, $fieldName, $fieldValue): int|string|bool|array|null
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $sql_query = "SELECT $fieldName FROM $tableName WHERE $fieldName = ?";
        $stmt = $this->conn->prepare($sql_query);
        $stmt->bind_param($this->getBindParamTypes([$fieldValue]), $fieldValue);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row[$fieldName];
        }

        $stmt->close(); // Close statement
        // $this->conn->close(); // Close Connection Object

        return null;
    }

    /**
     * retrieve multiple values from a specific field
     */
    public function retrieveMultipleValues(string $tableName, string $fieldName, string $comparefieldName, $comparefieldValue): array
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $sql_query = "SELECT $fieldName FROM $tableName WHERE $comparefieldName = ?";
        $stmt = $this->conn->prepare($sql_query);

        if ($stmt === false) {
            throw new Exception("Error in preparing statement: " . $this->conn->error);
        }

        $stmt->bind_param($this->getBindParamTypes([$comparefieldValue]), $comparefieldValue);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $columnValues = [];
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $columnValues[] = $row[0];
            }
            $stmt->close(); // Close Statement Object
            return $columnValues;
        }

        $stmt->close(); // Close Statement Object
        // $this->conn->close(); // Close Connection
        return [];
    }

    /**
     * retrieve a single record as an associative array from a specific field
     */
    public function retrieveSingleRecord(string $tableName, string $fieldName, $fieldValue): array
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $sql_query = "SELECT * FROM $tableName WHERE $fieldName = ?";
        $stmt = $this->conn->prepare($sql_query);
        $stmt->bind_param($this->getBindParamTypes([$fieldValue]), $fieldValue);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        $stmt->close(); // Close statement
        // $this->conn->close(); // Close Connection Object

        return [];
    }

    /**
     * @param string $tableName Name of the table
     * @param array $sanitizedData Associative array containing the field names and values to update
     * @param string $fieldName Name of the field to match for the update
     * @param mixed $fieldValue Value of the field to match for the update
     * @return bool True if the update was successful, false otherwise
     */
    public function updateRecord(string $tableName, array $sanitizedData, string $fieldName, $fieldValue): bool
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $updateFields = "";
        foreach ($sanitizedData as $column => $value) {
            $updateFields .= "`$column`=?,";
        }
        $updateFields = rtrim($updateFields, ',');

        $types = $this->getBindParamTypes($sanitizedData);

        $sql_query = "UPDATE $tableName SET $updateFields WHERE $fieldName = ?";
        $stmt = $this->conn->prepare($sql_query);

        // Bind parameters
        $bindTypes = $types . $this->getBindParamTypes([$fieldValue]);
        $bindParams = array_values($sanitizedData);
        $bindParams[] = $fieldValue;
        $stmt->bind_param($bindTypes, ...$bindParams);

        $status = $stmt->execute();

        $stmt->close(); // Close statement
        // $this->conn->close(); // Close connection

        return $status;
    }

    public function deleteRecord(string $tableName, string $fieldName, string $fieldValue): bool
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        $paramTypes = $this->getBindParamTypes([$fieldValue]);
        $sql_query = "DELETE FROM $tableName WHERE $fieldName = ?";
        $stmt = $this->conn->prepare($sql_query);
        $stmt->bind_param($paramTypes, $fieldValue);
        $status = $stmt->execute();

        $stmt->close(); // Close statement
        // $this->conn->close(); // Close connection

        return $status;
    }

    public function retrieveTableReport(string $tableName, array $tableFields, array $joins, array $joinConditions): array
    {
        if (!$this->conn instanceof mysqli) {
            throw new Exception("No database connection available.");
        }

        // Construct table fields
        $fieldNames = implode(", ", $tableFields);

        // Construct join statements
        $joinStatements = "";
        foreach ($joins as $index => $join) {
            $joinType = $join['type'];
            $joinTable = $join['table'];
            $joinCondition = $joinConditions[$index];
            $joinStatements .= "$joinType JOIN $joinTable ON $joinCondition ";
        }

        // Construct SQL query
        $sql_query = "SELECT $fieldNames FROM $tableName $joinStatements";

        $result = $this->conn->query($sql_query);

        if ($result->num_rows > 0) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            $result->close(); // Close Result Object
            return $rows;
        } else {
            // $this->conn->close(); // Close connection
            return [];
        }
    }
}
