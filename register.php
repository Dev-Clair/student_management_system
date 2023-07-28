<?php
session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (filter_has_var(INPUT_POST, 'registerForm')) {
        $validUserInputs = []; // Declare an empty array to store form field values
        $errors = []; // Declare and initialize an error rray variable
        // Register Form Processing

        /** Name field */
        $regpattern = '/^[A-Za-z]+(?:\s+[A-Za-z]+)*$/';
        $name = filter_input(INPUT_POST, 'name', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($name !== false && $name !== null) {
            $validUserInputs['adminname'] = $name;
        } else {
            $errors['name'] = "Please Enter a Valid Name";
        }

        /** Email field */
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        if ($email !== false && $email !== null) {
            //This can be improved by using an email-API validator to check if the email is valid and allowed
            $validUserInputs['email'] = $email;
        } else {
            $errors['email'] = "Please Enter a valid email";
        }

        /** Year of Birth field */
        $yearOfBirth = filter_input(INPUT_POST, 'yearOfBirth', FILTER_DEFAULT);
        $yearOfBirth = date('Y', strtotime($yearOfBirth));

        /** Password field */
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];

        if ($password !== $confirmpassword) {
            $errors['password'] = "Passwords do not match";
        }
        $validUserInputs['password_hash'] = password_hash($password, PASSWORD_BCRYPT);

        if (!empty($errors)) {
            // Redirect to register page with error message
            $errorMessage = "Invalid Details";
            $_SESSION['errorMessage'] = $errorMessage;
            $_SESSION['errors'] = $errors;
            header('Location: register.php');
        }
        // Enter User Details into Database
        $validUserInputs['adminID'] = "Usr" . $yearOfBirth;
        $databaseName = "login";
        $conn = tableOpConnection($databaseName);
        $status = $conn->createRecords("admin", $validUserInputs);
        if ($status === true) {
            // Redirect user to index page with success message
            $successMessage = "User Account Created Successfully! Log-in using email or adminID";
            $_SESSION['successMessage'] = $successessage;
            header('Location: index.php');
            exit();
        }
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
    <title>Create User Account</title>
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

    <!--Register  Form -->
    <section>
        <div class="container pt-4 pr-3 pb-4 pl-3 mt-4 mb-4">
            <h3 class="mb-4">Fill in your personal details to create an account.</h3>
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
            <form id="registerForm" name="registerForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" value="" autocomplete="off" />
                    <?php if (isset($_SESSION['errors']['name'])) { ?>
                        <small class="error-message"><?php echo htmlspecialchars($_SESSION['errors']['name']); ?></small>
                    <?php } ?>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" value="" autocomplete="off" />
                    <?php if (isset($_SESSION['errors']['email'])) { ?>
                        <small class="error-message"><?php echo htmlspecialchars($_SESSION['errors']['email']); ?></small>
                    <?php } ?>
                </div>
                <div class="form-group mb-3">
                    <label for="yearOfBirth" class="form-label">Date of Birth:</label>
                    <input type="date" name="yearOfBirth" id="yearOfBirth" class="form-control" placeholder="Enter year of Birth" value="" autocomplete="off" />
                </div>
                <div class="formgroup mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" value="" autocomplete="off" />
                    <?php if (isset($_SESSION['errors']['password'])) { ?>
                        <small class="error-message"><?php echo htmlspecialchars($_SESSION['errors']['password']); ?></small>
                    <?php } ?>
                </div>
                <div class="formgroup mb-3">
                    <label for="confirmpassword" class="form-label">Confirm Password:</label>
                    <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm password" value="" autocomplete="off" />
                    <?php if (isset($_SESSION['errors']['password'])) { ?>
                        <small class="error-message"><?php echo htmlspecialchars($_SESSION['errors']['password']); ?></small>
                    <?php } ?>
                </div>
                <?php
                unset($_SESSION['errors']);
                ?>
                <button type="submit" name="registerForm" class="btn btn-success">Submit</button>
            </form>
        </div>
    </section>

    <?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/footer.php';
    ?>