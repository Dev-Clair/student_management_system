<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';

/** *******************************************Create Databases***************************************** */
$databaseName = "`student`";
print_r(dbConnection($databaseName));

$databaseName = "`course`";
print_r(dbConnection($databaseName));

$databaseName = "`modules`";
print_r(dbConnection($databaseName));

/** *******************************************Create Tables***************************************** */
$databaseName = "``";
$tableName = "``";
$fieldNames = ", `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
// $connection = tableConnection($databaseName);
// print_r($connection->createTable($tableName, $fieldNames));

$databaseName = "``";
$tableName = "``";
$fieldNames = "";
// $connection = tableConnection($databaseName);
// print_r($connection->createTable($tableName, $fieldNames));

$databaseName = "``";
$tableName = "``";
$fieldNames = "``";
// $connection = tableConnection($databaseName);
// print_r($connection->createTable($tableName, $fieldNames));

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
