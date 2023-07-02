<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbController.php';

$connection = new DbConnection($serverName = "localhost", $userName = "root", $password = "", $database = "");
$conn = $connection->getConnection();
$operation = new DbTable($conn);


/** *******************************************Create Tables***************************************** */
$tableName = "";
$fieldNames = ", `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
// print_r($operation->createTable($tableName, $fieldNames));

$tableName = "";
$fieldNames = "";
// print_r($operation->createTable($tableName, $fieldNames));

$tableName = "";
$fieldNames = "";
// print_r($operation->createTable($tableName, $fieldNames));

/** *******************************************Alter Tables***************************************** */
$tableName = "";
$statement = "ADD COLUMN `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER" . "";
// print_r($operation->alterTable($tableName, $statement));

/** *******************************************Truncate Tables***************************************** */
$tableName = "";
// print_r($operation->truncateTable($tableName));

/** *******************************************Drop Tables***************************************** */
$tableName = "";
// print_r($operation->dropTable($tableName));
