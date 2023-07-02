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
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css" />
  <link rel="stylesheet" href="style.css" />
</head>

<body class="container-fluid">
  <header class="container-fluid">
    <!-- Nav -->
    <nav>
      <ul>
        <li>
          <a href="./" class="contrast" onclick="event.preventDefault()"><strong>Home</strong></a>
          <a href="./" class="contrast" onclick="event.preventDefault()"><strong>Alumni</strong></a>
          <a href="./" class="contrast" onclick="event.preventDefault()"><strong>About</strong></a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- Main -->
  <main class="container">
    <article class="grid">
      <div>
        <h1>Sign in</h1>
        <form>
          <label for="login">Login ID:</label>
          <input type="text" name="login" id="login" placeholder="Enter Login ID" aria-label="Login" />
          <label for="password">Password:</label>
          <input type="password" name="password" id="password" placeholder="Enter Password" aria-label="Password" />
          <fieldset>
            <label for="remember">
              <input type="checkbox" role="switch" id="remember" name="remember" />
              Remember me
            </label>
          </fieldset>
          <button type="submit" class="contrast">Login</button>
        </form>
      </div>
      <div></div>
    </article>
  </main>

  <!-- Footer -->
  <footer class="container-fluid">
    <small>&copy; 2023 jagaad academy</small>
  </footer>
</body>

</html>