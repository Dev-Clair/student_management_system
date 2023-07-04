<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';
$connection = dbTableConnection();

/** *******************************************Create Tables***************************************** */
$tableName = "";
$fieldNames = ", `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
// print_r($connection->createTable($tableName, $fieldNames));

$tableName = "";
$fieldNames = "";
// print_r($connection->createTable($tableName, $fieldNames));

$tableName = "";
$fieldNames = "";
// print_r($connection->createTable($tableName, $fieldNames));

/** *******************************************Alter Tables***************************************** */
$tableName = "";
$statement = "ADD COLUMN `datecreated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER" . "";
// print_r($connection->alterTable($tableName, $statement));

/** *******************************************Truncate Tables***************************************** */
$tableName = "";
// print_r($connection->truncateTable($tableName));

/** *******************************************Drop Tables***************************************** */
$tableName = "";
// print_r($connection->dropTable($tableName));
