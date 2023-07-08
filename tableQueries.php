<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';

/** *******************************************Create Databases***************************************** */
$databaseName = "grade";
// print_r(dbConnection($databaseName));
echo "\n";

$databaseName = "student";
// print_r(dbConnection($databaseName));
echo "\n";

$databaseName = "course";
// print_r(dbConnection($databaseName));
echo "\n";

$databaseName = "module";
// print_r(dbConnection($databaseName));
echo "\n";


/** *******************************************Create Tables***************************************** */
/** ******* Grade Database Tables*******/

$tableNames = array("frontend", "backend", "fullstack", "devops", "cloud");
$fieldNames = "`studentname` VARCHAR(50) NOT NULL,
               `coursename` VARCHAR(100) NOT NULL,
               `modulename` VARCHAR(100) NOT NULL,
               `chaptername` VARCHAR(100) NOT NULL,
               `exercisescore` INT(3),
               `projectscore` INT(3),
               `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

$databaseName = "grade";
// foreach ($tableNames as $tableName) {
//     $conn = tableConnection($databaseName);
//     $dbTable = new DbTable($conn);
//     $result = $dbTable->createTable("`$tableName`", $fieldNames);
//     echo "Creating table $tableName: ";
//     if ($result) {
//         echo "Success\n";
//     } else {
//         echo "Failure\n";
//     }
// }

/********* Student Database Tables*******/

$tableNames = array("frontend", "backend", "fullstack", "devops", "cloud");
$fieldNames = "`studentname` VARCHAR(50) NOT NULL,
                `regno.` INT(20) UNIQUE NOT NULL,
                `coursename` VARCHAR(100) NOT NULL,
               `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

$databaseName = "student";
// foreach ($tableNames as $tableName) {
//     $conn = tableConnection($databaseName);
//     $dbTable = new DbTable($conn);
//     $result = $dbTable->createTable("`$tableName`", $fieldNames);
//     echo "Creating table $tableName: ";
//     if ($result) {
//         echo "Success\n";
//     } else {
//         echo "Failure\n";
//     }
// }

/** ******* Course Database Table*******/

$tableName = "modules";
$fieldNames = "`coursename` VARCHAR(100) NOT NULL,
               `moduleID` VARCHAR(10) UNIQUE NOT NULL,
               `modulename` VARCHAR(100) UNIQUE NOT NULL,
                `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

$databaseName = "course";
// $conn = tableConnection($databaseName);
// $dbTable = new DbTable($conn);
// $result = $dbTable->createTable("`$tableName`", $fieldNames);
// if ($result) {
//         echo "Success\n";
//     } else {
//         echo "Failure\n";
//     }

/** ******* Module Database Table*******/

$tableName = "chapters";
$fieldNames = "`modulename` VARCHAR(100) NOT NULL,
               `chapterID` VARCHAR(10) UNIQUE NOT NULL,
               `chaptername` VARCHAR(100) UNIQUE NOT NULL,
                `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

// $databaseName = "module";
// $conn = tableConnection($databaseName);
// $dbTable = new DbTable($conn);
// $result = $dbTable->createTable("`$tableName`", $fieldNames);
// if ($result) {
//     echo "Success\n";
// } else {
//     echo "Failure\n";
// }


/** *******************************************Alter Tables***************************************** */
$databaseName = "module";
$tableName = "chapters";
$alterStatement = "ADD COLUMN `coursename` VARCHAR(100) NOT NULL FIRST";
// $conn = tableConnection($databaseName);
// $dbTable = new DbTable($conn);
// $result = $dbTable->alterTable("`$tableName`", $alterStatement);


/** *******************************************Truncate Tables***************************************** */
$databaseName = "";
$tableName = "";
// $conn = tableConnection($databaseName);
// $dbTable = new DbTable($conn);
// $result = $dbTable->truncateTable("`$tableName`");


/** *******************************************Drop Tables***************************************** */
$databaseName = "";
$tableName = "";
// $conn = tableConnection($databaseName);
// $dbTable = new DbTable($conn);
// $result = $dbTable->dropTable("`$tableName`");
