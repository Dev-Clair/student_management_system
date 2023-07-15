<?php
session_start(); // Starts session for current script
// Retrieve Session Variables and verify loginStatus
$userID = $_SESSION['userID'];
$loginStatus = $_SESSION['loginStatus'];
if ($userID === null && $loginStatus === null) {
    // Redirect to login page withinvalid login status
    $errorMessage = "Invalid Login Status! Please login again.";
    $_SESSION['errorMessage'] = $errorMessage;
    header('Location: index.php');
    exit();
}
session_regenerate_id();

// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';

$fieldName = "regno.";
$fieldValue = (int)$_GET['studentid'] ?? null;
$tableName = $_GET['coursename'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /** ADD STUDENT FORM */
    if (filter_has_var(INPUT_POST, 'updatestudentForm')) {
        // Student Form Processing
        $updateErrors = []; // Declare an error array variable
        $updateValidInputs = []; // Declare an empty  array to store valid form fields

        /** Studentname field */
        $regpattern = '/^[A-Za-z]+(?:\s+[A-Za-z]+)*$/';
        $studentname = filter_input(INPUT_POST, 'studentname', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($studentname !== false && $studentname !== null) {
            $updateValidInputs['studentname'] = ucwords($studentname);
        } else {
            $updateErrors['studentname'] = "Name cannot contain numbers or non-alphabetic characters";
        }

        /**Coursename field */
        $courseoptions = array("frontend", "backend", "fullstack", "devops", "cloud");
        $coursename = filter_input(INPUT_POST, 'coursename', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($coursename !== null && in_array($coursename, $courseoptions)) {
            $updateValidInputs['coursename'] = $coursename;
        } else {
            $updateErrors['coursename'] = "Please select a valid course";
        }

        if (!empty($studentErrors)) {
            // Redirect to admin page with error message
            $errorMessage = "Invalid Entries";
            $_SESSION['errorMessage'] = $errorMessage;
            $_SESSION['updateErrors'] = $studentUpdateErrors;
            header('Location: admin.php');
            exit();
        }
        // Submits Form Data
        $databaseName = "student";
        $conn = tableOpConnection($databaseName);
        $tableName = $databaseName . "." . $updateValidInputs['coursename'];
        $status = $conn->updateRecordFields($tableName, $studentValidInputs, $fieldName, $fieldValue);
        if ($status === true) {
            // Redirect to admin page with success message
            $successMessage = "Record Updated Successfully";
            $_SESSION['successMessage'] = $successMessage;
            header('Location: admin.php');
            exit();
        }
    }
    // Redirect to admin page with error message
    $errorMessage = "Error! Process failed, Please try again.";
    $_SESSION['errorMessage'] = $errorMessage;
    header('Location: admin.php');
    exit();
}

$databaseName = "student";
$conn = tableOpConnection($databaseName);
$status = $conn->validateFieldValue($tableName, $fieldName, $fieldValue);
if ($status !== true) {
    // Redirect to admin page with error message
    $errorMessage = "Error! Record Not Found.";
    $_SESSION['errorMessage'] = $errorMessage;
    header('Location: admin.php');
    exit();
}
$record = $conn->retrieveSingleRecord($tableName, $fieldName, $fieldValue);

?>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/header.php';
?>

<div class="container">
    <?php
    if (isset($_SESSION['errorMessage'])) {
        $errorMessage = $_SESSION['errorMessage'];
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
        unset($_SESSION['errorMessage']);
    }
    ?>

    <form id="updatestudentForm" name="updatestudentForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label class="mb-2" for="studentname"><strong>Name:</strong></label>
            <input type="text" class="form-control mb-2" id="studentname" name="studentname" value="" autocomplete="off" placeholder="Enter name" />
            <?php if (isset($_SESSION['updateErrors']['studentname'])) { ?>
                <small class="error-message"><?php echo $_SESSION['updateErrors']['studentname']; ?></small>
            <?php } ?>
        </div>
        <div class="form-group">
            <label class="mb-2" for="coursename"><strong>Select Course:</strong></label>
            <select class="form-control mb-2" id="coursename" name="coursename">
                <option value="">--Click to Select--</option>
                <option value="frontend" disabled>Frontend</option>
                <option value="backend">Backend</option>
                <option value="fullstack" disabled>Fullstack</option>
                <option value="devops" disabled>Devops</option>
                <option value="cloud" disabled>Cloud</option>
            </select>
            <?php if (isset($_SESSION['updateErrors']['coursename'])) { ?>
                <small class="error-message"><?php echo $_SESSION['updateErrors']['coursename']; ?></small>
            <?php } ?>
        </div>
        <?php
        unset($_SESSION['updateErrors']);
        ?>
        <button type="submit" name="updatestudentForm" class="float-end btn btn-primary">
            Submit
        </button>
    </form>
</div>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/footer.php';
?>