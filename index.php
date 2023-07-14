<?php
session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $userinputs = []; // Declare an empty  array to store form field values
  $loginStatus = false; // Declare and initialize loginSttus to false
  if (filter_has_var(INPUT_POST, 'loginForm')) {
    // Login Form Processing

    /** Login-ID field */
    $regpattern = '/^[A-Z][a-z]{2}[\d]{4}$/';
    $loginID = filter_input(INPUT_POST, 'loginID', FILTER_VALIDATE_REGEXP, array(
      'options' => array('regexp' => $regpattern)
    ));

    if ($loginID !== false && $loginID !== null) {
      $userinputs['loginID'] = $loginID;
    }

    /** Password field */
    $userinputs['password'] = $_POST['password'];

    // Retrieve User Details from Database 
    $databaseName = "login";
    $conn = tableOpConnection($databaseName);
    $record = $conn->retrieveSingleRecord("admin", "adminID", $loginID);
    $retrievedAdminID = $record['adminID'];
    $retrievedPassword = $record['password_hash'];
    // Verify Form Data
    if ($retrievedAdminID === $userinputs['loginID'] && password_verify($userinputs['password'], $retrievedPassword)) {
      // Start and save userID and loginStatus to session global variable
      $loginStatus = true;
      $_SESSION['userID'] = $retrievedAdminID;
      $_SESSION['loginStatus'] = $loginStatus;
      // Redirect to main page
      header('Location: main.php');
      exit();
    }
    // Redirect to index page with error message
    $errorMessage = "Invalid Details";
    $_SESSION['errorMessage'] = $errorMessage;
    header('Location: index.php');
    exit();
  }
  // Redirect to index page with error message
  $errorMessage = "Error! Process failed, Please try again.";
  $_SESSION['errorMessage'] = $errorMessage;
  header('Location: index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css" />
  <title>Log in</title>
</head>

<body class="container pt-4 pr-3 pb-4 pl-3 mt-4 mb-4">
  <header class="flex fixed-top bg-secondary my-1 py-3">
    <!-- Nav -->
    <nav class="flex-left btn-grp">
      <a href="./academics.php" class="btn text-white ml-5 mr-5" onclick="event.preventDefault()"><strong>ACADEMICS</strong></a>
      <a href="./about.php" class="btn text-white ml-5 mr-5" onclick="event.preventDefault()"><strong>ABOUT US</strong></a>
      <a href="./units.php" class="btn text-white ml-5 mr-5" onclick="event.preventDefault()"><strong>UNITS</strong></a>
      <a href="./research.php" class="btn text-white ml-5 mr-5" onclick="event.preventDefault()"><strong>RESEARCH</strong></a>
      <a href="./resources.php" class="btn text-white ml-5 mr-5" onclick="event.preventDefault()"><strong>RESOURCES</strong></a>
      <a href="./donations.php" class="btn text-white ml-5 mr-5" onclick="event.preventDefault()"><strong>ACADEMY</strong></a>
    </nav>
  </header>

  <!--Login  Form -->
  <section>
    <div class="container pt-4 pr-3 pb-4 pl-3 mt-4 mb-4">
      <h1 class="mb-4">Log in</h1>
      <?php
      if (isset($_SESSION['errorMessage'])) {
        $errorMessage = $_SESSION['errorMessage'];
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
        unset($_SESSION['errorMessage']);
      }

      if (isset($_SESSION['successMessage'])) {
        $successMessage = $_SESSION['successMessage'];
        echo '<div class="alert alert-success">' . $successMessage . '</div>';
        unset($_SESSION['successMessage']);
      }
      ?>
      <form id="loginForm" name="loginForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group mb-3">
          <label for="login" class="form-label">Login-ID:</label>
          <input type="text" name="loginID" id="login" class="form-control" placeholder="Enter adminID" value="<?php echo htmlspecialchars($userinputs['loginID'] ?? ''); ?>" autocomplete="off" />
        </div>
        <div class="formgroup mb-3">
          <label for="password" class="form-label">Password:</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" value="" autocomplete="off" />
        </div>
        <button type="submit" name="loginForm" class="btn btn-primary">Log in</button>
      </form>
    </div>
  </section>

  <?php
  require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/footer.php';
  ?>