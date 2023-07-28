<?php

use Dotenv\Dotenv;

// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource/dbConn.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource/dbController.php';
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/******* Create/Drop Database ******/
function dbConnection(string $databaseName): bool
{
    $conn = new DbConnection($_ENV["DATABASE_HOSTNAME"], $_ENV["DATABASE_USERNAME"], $_ENV["DATABASE_PASSWORD"]);
    $conn = $conn->getConnection();

    if (!$conn instanceof mysqli) {
        throw new Exception('Connection failed.');
    }

    $sql_query = "CREATE DATABASE IF NOT EXISTS $databaseName";
    // $sql_query = "DROP DATABASE $databaseName";
    if ($conn->query($sql_query) === true) {
        return true;
    } else {
        throw new \RuntimeException('Database creation failed: ' . $conn->error);
    }
}

/******* Create/Drop/Truncate/Alter Table ******/
function tableConnection(string $databaseName): DbTable
{
    $conn = new DbConnection($_ENV["DATABASE_HOSTNAME"], $_ENV["DATABASE_USERNAME"], $_ENV["DATABASE_PASSWORD"], $databaseName);
    $conn = $conn->getConnection();
    $conn = new DbTable($conn);
    return $conn;
}

/******* Table Read and Write Operations ******/
function tableOpConnection(string $databaseName): DbTableOps
{
    $connection = new DbConnection($_ENV["DATABASE_HOSTNAME"], $_ENV["DATABASE_USERNAME"], $_ENV["DATABASE_PASSWORD"], $databaseName);
    $conn = $connection->getConnection();
    $conn = new DbTableOps($conn);
    return $conn;
}


/** *******************************************Create Databases***************************************** */
ob_start();

$databaseName = ["student", "course", "grade", "module", "login"];
foreach ($databaseName as $database) {
    print_r(dbConnection($database)) . PHP_EOL;
}

/** Create admin table in login database */
$tableName = "admin";
$fieldNames = "`adminID` VARCHAR(50) PRIMARY KEY NOT NULL,
               `adminname` VARCHAR(100) NOT NULL,
               `email` VARCHAR(100) UNIQUE NOT NULL,
               `password_hash` VARCHAR(255) NOT NULL,
               `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

$databaseName = "login";
$conn = tableConnection($databaseName);
$result = $conn->createTable("`$tableName`", $fieldNames);
echo "Creating table $tableName: ";
if ($result) {
    echo "Success" . PHP_EOL;
} else {
    echo "Failure" . PHP_EOL;
}

/** Create tables in grade database*/
$tableNames = array("frontend", "backend", "fullstack", "devops", "cloud");
$fieldNames = "`studentname` VARCHAR(50) NOT NULL,
               `coursename` VARCHAR(100) NOT NULL,
               `modulename` VARCHAR(100) NOT NULL,
               `chaptername` VARCHAR(100) NOT NULL,
               `exercisescore` INT(3),
               `projectscore` INT(3),
               `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

$databaseName = "grade";
foreach ($tableNames as $tableName) {
    $conn = tableConnection($databaseName);
    $result = $conn->createTable("`$tableName`", $fieldNames);
    echo "Creating table $tableName: ";
    if ($result) {
        echo "Success" . PHP_EOL;
    } else {
        echo "Failure" . PHP_EOL;
    }
}

/** Create tables in student database */
$tableNames = array("frontend", "backend", "fullstack", "devops", "cloud");
$fieldNames = "`studentname` VARCHAR(50) NOT NULL,
                `regno.` INT(20) UNIQUE NOT NULL,
                `coursename` VARCHAR(100) NOT NULL,
               `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

$databaseName = "student";
foreach ($tableNames as $tableName) {
    $conn = tableConnection($databaseName);
    $result = $conn->createTable("`$tableName`", $fieldNames);
    echo "Creating table $tableName: ";
    if ($result) {
        echo "Success" . PHP_EOL;
    } else {
        echo "Failure" . PHP_EOL;
    }
}

/** Create modules table in course database */
$tableName = "modules";
$fieldNames = "`coursename` VARCHAR(100) NOT NULL,
               `moduleID` VARCHAR(10) UNIQUE NOT NULL,
               `modulename` VARCHAR(100) UNIQUE NOT NULL,
                `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

$databaseName = "course";
$conn = tableConnection($databaseName);
$result = $conn->createTable("`$tableName`", $fieldNames);
echo "Creating table $tableName: ";
if ($result) {
    echo "Success" . PHP_EOL;
} else {
    echo "Failure" . PHP_EOL;
}

/** Create chapters table in module database */
$tableName = "chapters";
$fieldNames = "`coursename` VARCHAR(100) NOT NULL,
                `modulename` VARCHAR(100) NOT NULL,
               `chapterID` VARCHAR(10) UNIQUE NOT NULL,
               `chaptername` VARCHAR(100) UNIQUE NOT NULL,
                `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

$databaseName = "module";
$conn = tableConnection($databaseName);
$result = $conn->createTable("`$tableName`", $fieldNames);
echo "Creating table $tableName: ";
if ($result) {
    echo "Success" . PHP_EOL;
} else {
    echo "Failure" . PHP_EOL;
}

ob_clean();
ob_end_clean();
