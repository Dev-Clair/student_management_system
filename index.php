<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbSource.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbController.php';

$connection = new DbConnection($serverName = "localhost", $userName = "root", $password = "", $database = "");
$conn = $connection->getConnection();
$operation = new DbTableOps($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.fluid.classless.min.css">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css" /> -->
  <link rel="stylesheet" href="style.css" />
  <title>Jagaad Academy</title>
</head>

<body class="container-fluid">
  <h1>Index</h1>


  <!-- Footer -->
  <footer class="container-fluid">
    <small>&copy; 2023 jagaad academy</small>
  </footer>
</body>

</html>