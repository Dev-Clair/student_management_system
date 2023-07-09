<?php

use Dotenv\Dotenv;

// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource/dbConn.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource/dbController.php';
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/******* Create Database ******/
function dbConnection(string $databaseName): bool
{
    $conn = new DbConnection($_ENV["DATABASE_HOSTNAME"], $_ENV["DATABASE_USERNAME"], $_ENV["DATABASE_PASSWORD"]);
    $conn = $conn->getConnection();

    if (!is_resource($conn)) {
        throw new Exception('Connection failed.');
    }

    $sql_query = "CREATE DATABASE $databaseName";
    if ($conn->query($sql_query) === true) {
        $conn->closeConnection();
        return true;
    } else {
        throw new Exception('Database creation failed: ' . $conn->error);
    }
}

/******* Create Table ******/
function tableConnection(string $databaseName): ?mysqli
{
    $conn = new DbConnection($_ENV["DATABASE_HOSTNAME"], $_ENV["DATABASE_USERNAME"], $_ENV["DATABASE_PASSWORD"], $databaseName);
    $conn = $conn->getConnection();
    return $conn;
}

/******* Table Read and Write Operations ******/
function tableOpConnection(string $databaseName): ?mysqli
{
    $connection = new DbConnection($_ENV["DATABASE_HOSTNAME"], $_ENV["DATABASE_USERNAME"], $_ENV["DATABASE_PASSWORD"], $databaseName);
    $conn = $connection->getConnection();
    return $conn;
}
