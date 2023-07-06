<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';
$databaseName = "";
$connection = tableConnection($databaseName);

// Form Handling: Validation, Processing and Submission
?>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/header.php';
?>
<!-- Form -->
<section>
  <div class="container pt-4 pr-3 pb-4 pl-3 mt-4 mb-4">
    <h1 class="mb-4">Sign in</h1>
    <form method="get" , action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
      <div class="form-group mb-3">
        <label for="login" class="form-label">Login ID:</label>
        <input type="text" name="login" id="login" class="form-control" placeholder="Enter Login ID" value="" />
      </div>
      <div class="formgroup mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" value="" />
      </div>
      <div class="formgroup mb-3">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="remember" name="remember" value="" />
          <label class="form-check-label" for="remember">Remember me</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
</section>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/footer.php';
?>