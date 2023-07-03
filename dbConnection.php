<?php

use Dotenv\Dotenv;

// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . './DbConnection/dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . './DbConnection/dbController.php';
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function connection()
{
    $connection = new DbConnection($_ENV["DATABASE_HOSTNAME"], $_ENV["DATABASE_USERNAME"], $_ENV["DATABASE_PASSWORD"], $_ENV["DATABASE_NAME"]);
    $conn = $connection->getConnection();
    $conn = new DbTableOps($conn);
    return $conn;
}
