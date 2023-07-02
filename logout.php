<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbController.php';

$connection = new DbConnection($serverName = "localhost", $userName = "root", $password = "", $database = "");
$conn = $connection->getConnection();
$operation = new DbTableOps($conn);
