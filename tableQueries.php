<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';

/** *******************************************Create Databases***************************************** */
$databaseName = "grade";
// print_r(dbConnection($databaseName));
// echo "\n";

$databaseName = "student";
// print_r(dbConnection($databaseName));
// echo "\n";

$databaseName = "course";
// print_r(dbConnection($databaseName));
// echo "\n";

$databaseName = "module";
// print_r(dbConnection($databaseName));
// echo "\n";

/** *******************************************Create Tables***************************************** */
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
    $connection = tableConnection($databaseName);
    $result = $connection->createTable("`$tableName`", $fieldNames);
    echo "Creating table $tableName: ";
    if ($result) {
        echo "Success";
    } else {
        echo "Failure";
    }
    echo "\n";
}

$tableNames = array("frontend", "backend", "fullstack", "devops", "cloud");
$fieldNames = "`studentname` VARCHAR(50) NOT NULL,
                `regno.` INT(20) UNIQUE NOT NULL,
                `coursename` VARCHAR(100) NOT NULL,
               `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

$databaseName = "student";
foreach ($tableNames as $tableName) {
    $connection = tableConnection($databaseName);
    $result = $connection->createTable("`$tableName`", $fieldNames);
    echo "Creating table $tableName: ";
    if ($result) {
        echo "Success";
    } else {
        echo "Failure";
    }
    echo "\n";
}

$tableName = "modules";
$fieldNames = "`coursename` VARCHAR(100) NOT NULL,
               `moduleID` VARCHAR(10) UNIQUE NOT NULL,
               `modulename` VARCHAR(100) UNIQUE NOT NULL,
                `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

$databaseName = "course";
$connection = tableConnection($databaseName);
print_r($connection->createTable("`$tableName`", $fieldNames));
echo "\n";

$tableName = "chapters";
$fieldNames = "`modulename` VARCHAR(100) NOT NULL,
               `chapterID` VARCHAR(10) UNIQUE NOT NULL,
               `chaptername` VARCHAR(100) UNIQUE NOT NULL,
                `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

$databaseName = "module";
$connection = tableConnection($databaseName);
print_r($connection->createTable("`$tableName`", $fieldNames));
echo "\n";

/** *******************************************Alter Tables***************************************** */
$databaseName = "``";
$tableName = "``";
$statement = "ADD COLUMN `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER" . "";
// $connection = tableConnection($databaseName);
// print_r($connection->alterTable($tableName, $statement));

/** *******************************************Truncate Tables***************************************** */
$databaseName = "``";
$tableName = "``";
// $connection = tableConnection($databaseName);
// print_r($connection->truncateTable($tableName));

/** *******************************************Drop Tables***************************************** */
$databaseName = "``";
$tableName = "``";
// $connection = tableConnection($databaseName);
// print_r($connection->dropTable($tableName));
