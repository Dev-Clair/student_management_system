<?php

use Dotenv\Dotenv;

// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'DbConnection/dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'DbConnection/dbController.php';
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function newDb(string $databaseName): bool
{
    $connection = new DbConnection($_ENV["DATABASE_HOSTNAME"], $_ENV["DATABASE_USERNAME"], $_ENV["DATABASE_PASSWORD"]);
    $conn = $connection->getConnection();
    $sql_query = "CREATE DATABASE $databaseName";
    if ($conn->query($sql_query) === true) {
        return true;
    } else {
        throw new Exception('Database creation failed: ' . $conn->error);
    }
}

function dbTableConnection(string $databaseName): DbTable
{
    $connection = new DbConnection($_ENV["DATABASE_HOSTNAME"], $_ENV["DATABASE_USERNAME"], $_ENV["DATABASE_PASSWORD"], $databaseName);
    $conn = $connection->getConnection();
    $conn = new DbTable($conn);
    return $conn;
}

function dbTableOpConnection(string $databaseName): DbTableOps
{
    $connection = new DbConnection($_ENV["DATABASE_HOSTNAME"], $_ENV["DATABASE_USERNAME"], $_ENV["DATABASE_PASSWORD"], $databaseName);
    $conn = $connection->getConnection();
    $conn = new DbTableOps($conn);
    return $conn;
}
