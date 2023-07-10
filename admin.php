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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = []; // Declare an error array variable
    $validinputs = []; // Declare an empty  array to store valid form fields
    $invalidinputs = []; // Declare an empty  array to store invalid form fields
    if (filter_has_var(INPUT_POST, 'submitstudentForm')) {
        // Student Form Processing

        /** Studentname field */
        $regpattern = '/^[A-Za-z]+(?:\s+[A-Za-z]+)*$/';
        $studentname = filter_input(INPUT_POST, 'studentname', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($studentname !== false && $studentname !== null) {
            $validinputs['studentname'] = ucwords($studentname);
        } else {
            $errors['studentname'] = "Name cannot contain numbers or non-alpahbetic characters";
            $invalidinputs['studentname'] = $studentname;
        }

        /**Coursename field */
        $courseoptions = array("frontend", "backend", "fullstack", "devops", "cloud");
        $coursename = filter_input(INPUT_POST, 'coursename', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($coursename !== null && in_array($coursename, $courseoptions)) {
            $validinputs['coursename'] = $coursename;
        } else {
            $errors['coursename'] = "Please select a valid course";
            $invalidinputs['coursename'] = $coursename;
        }

        if (!empty($errors)) {
            // Redirect to admin page with error message
            $errorMessage = "Invalid Entries";
            $_SESSION['errorMessage'] = $errorMessage;
            header('Location: admin.php');
            exit();
        }
        // Submits Form Data
        $regNo = time();
        $validinputs['regno.'] = $regNo; // Assign registration number
        $databaseName = "student";
        $conn = tableOpConnection($databaseName);
        $conn = new DbTableOps($conn);
        $tableName = $validinputs['coursename'];
        $status = $conn->createRecords($tableName, $validinputs);
        if ($status) {
            // Redirect to admin page with success message
            $successMessage = "Entry Added Successfully";
            $_SESSION['successMessage'] = $successMessage;
            header('Location: admin.php');
            exit();
        }
    }

    if (filter_has_var(INPUT_POST, 'submitsmoduleForm')) {
        // Module Form Processing

        /**Coursename field */
        $courseoptions = array("frontend", "backend", "fullstack", "devops", "cloud");
        $coursename = filter_input(INPUT_POST, 'coursename', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($coursename !== null && in_array($coursename, $courseoptions)) {
            $validinputs['coursename'] = $coursename;
        } else {
            $errors['coursename'] = "Please select a valid course";
            $invalidinputs['coursename'] = $coursename;
        }

        /** ModuleID field */
        $regpattern = '/^[a-zA-Z]+\s{2}[\d]{1}$/';
        $moduleid = filter_input(INPUT_POST, 'moduleid', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($moduleid !== false && $moduleid !== null) {
            $validinputs['moduleid'] = $moduleid;
        } else {
            $errors['moduleid'] = "Invalid Module ID";
            $invalidinputs['moduleid'] = $moduleid;
        }

        /**Modulename field */
        $regpattern = '/^[a-zA-Z]+*$/';
        $modulename = filter_input(INPUT_POST, 'modulename', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($modulename !== false && $modulename !== null) {
            $validinputs['modulename'] = ucwords($modulename);
        } else {
            $errors['modulename'] = "Please choose a valid module";
            $invalidinputs['modulename'] = $modulename;
        }

        if (!empty($errors)) {
            // Redirect to admin page with error message
            $errorMessage = "Invalid Entries";
            $_SESSION['errorMessage'] = $errorMessage;
            header('Location: admin.php');
            exit();
        }
        // Submits Form Data
        $databaseName = "course";
        $conn = tableOpConnection($databaseName);
        $conn = new DbTableOps($conn);
        $tableName = "modules";
        $record = $conn->createRecords("$tableName", $validinputs);
        if ($record) {
            // Redirect to admin page with success message
            $successMessage = "Entry Added Successfully";
            $_SESSION['successMessage'] = $successMessage;
            header('Location: admin.php');
            exit();
        }
    }

    if (filter_has_var(INPUT_POST, 'submitschapterForm')) {
        // Chapter Form Validation and Processing

        /**Coursename field */
        $courseoptions = array("frontend", "backend", "fullstack", "devops", "cloud");
        $coursename = filter_input(INPUT_POST, 'coursename', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($coursename !== null && in_array($coursename, $courseoptions)) {
            $validinputs['coursename'] = $coursename;
        } else {
            $errors['coursename'] = "Please select a valid course";
            $invalidinputs['coursename'] = $coursename;
        }

        /** Modulename field */
        $databaseName = "course";
        $conn = tableOpConnection($databaseName);
        $conn = new DbTableOps($conn);
        global $coursename;
        $selectedcourse = $coursename;
        $fieldName = "`modulename`";
        $moduleoptions = $conn->retrieveMultipleValues("modules", $fieldName, $selectedcourse);
        $modulename = filter_input(INPUT_POST, 'modulename', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($modulename !== null && in_array($modulename, $moduleoptions)) {
            $validinputs['modulename'] = $modulename;
        } else {
            $errors['modulename'] = "Please choose a valid module";
            $invalidinputs['modulename'] = $modulename;
        }

        /** ChapterID field */
        $regpattern = '/^[A-Z]+[\d]+$/';
        $chapterid = filter_input(INPUT_POST, 'chapterid', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($chapterid !== false && $chapterid !== null) {
            $validinputs['chapterid'] = $chapterid;
        } else {
            $errors['chapterid'] = "Invalid! Can contain cap. letters and numbers only";
            $invalidinputs['chapterid'] = $chapterid;
        }

        /** Chaptername field */
        $regpattern = '/^[a-zA-Z]+*$/';
        $chaptername = filter_input(INPUT_POST, 'chaptername', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($chaptername !== false && $chaptername !== null) {
            $validinputs['chaptername'] = ucwords($chaptername);
        } else {
            $errors['chaptername'] = "Please select a valid chapter name";
            $invalidinputs['chaptername'] = $chaptername;
        }

        if (!empty($errors)) {
            // Redirect to admin page with error message
            $errorMessage = "Invalid Entries";
            $_SESSION['errorMessage'] = $errorMessage;
            header('Location: admin.php');
            exit();
        }
        // Submits Form Data
        $databaseName = "module";
        $conn = tableOpConnection($databaseName);
        $conn = new DbTableOps($conn);
        $tableName = "chapters";
        $record = $conn->createRecords("$tableName", $validinputs);
        if ($record) {
            // Redirect to admin page with success message
            $successMessage = "Entries Added Successfully";
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
?>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/header.php';
?>
<!-- Form Buttons and Tables -->
<div class="float-left">
    <!-- New Student Button trigger modal -->
    <button type="button" class="btn btn-primary my-3 mb-3" data-bs-toggle="modal" data-bs-target="#createStudentModal">
        New Student
    </button>
    <!-- Module Button trigger modal -->
    <button type="button" class="btn btn-primary my-3 mb-3" data-bs-toggle="modal" data-bs-target="#createModuleModal">
        New Module
    </button>
    <!-- Chapter Button trigger modal -->
    <button type="button" class="btn btn-primary my-3 mb-3" data-bs-toggle="modal" data-bs-target="#createChapterModal">
        New Chapter
    </button>
</div>
<div class="container table-wrapper">
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

    <table class="table table-striped table-bordered mt-4">
        <thead class="thead-dark">
            <tr>
                <th>S/n</th>
                <th>Name</th>
                <th>Registration No.</th>
                <th>Course Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // retrieves tablenames in database
            $databaseName = "student";
            // $conn = tableConnection($databaseName);
            // $conn = new DbTable($conn);
            // $tableNames = $conn->retrieveTableNames($databaseName);
            // $tableName = $tableNames[1];
            $tableName = "backend";
            // displays table based on tablename
            $conn = tableOpConnection($databaseName);
            $conn = new DbTableOps($conn);
            $records = $conn->retrieveAllRecords("$tableName");
            if (!empty($records)) {
                $count = 0;
                foreach ($records as $row) {
                    $count++;
            ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row["studentname"]; ?></td>
                        <td><?php echo $row["regno."]; ?></td>
                        <td><?php echo $row["coursename"]; ?></td>
                        <td class="btn-group">
                            <a href="update.php?studentid=<?php echo $row["regno."]; ?>" class="btn btn-primary btn-sm ms-2">Update</a>
                            <a href="admin.php?action=delete&studentid=<?php echo $row["regno."]; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">No records found.</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- New Student Modal -->
<div class="modal fade" id="createStudentModal" tabindex="-1" aria-labelledby="createStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createStudentModalLabel"><strong>New Student</strong> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="studentForm" name="studentForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <label class="mb-2" for="studentname"><strong>Name:</strong></label>
                        <input type="text" class="form-control mb-2" id="studentname" name="studentname" value="<?php echo htmlspecialchars($invalidinputs['studentname'] ?? ''); ?>" autocomplete="off" placeholder="Enter name" />
                        <?php if (isset($errors["studentname"])) { ?>
                            <small class="error-message"><?php echo $errors["studentname"]; ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label class="mb-2" for="coursename"><strong>Select Course:</strong></label>
                        <select class="form-control mb-2" id="coursename" name="coursename">
                            <option value="">--Click to Select--</option>
                            <option value="frontend">Frontend</option>
                            <option value="backend">Backend</option>
                            <option value="fullstack">Fullstack</option>
                            <option value="devops">Devops</option>
                            <option value="cloud">Cloud</option>
                        </select>
                        <?php if (isset($errors["coursename"])) { ?>
                            <small class="error-message"><?php echo $errors["coursename"]; ?></small>
                        <?php } ?>
                    </div>
                    <button type="submit" name="submitstudentForm" class="float-end btn btn-primary">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- New Module Modal -->
<div class="modal fade" id="createModuleModal" tabindex="-1" aria-labelledby="createModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModuleModalLabel"><strong>Course Module</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="moduleForm" name="moduleForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group mb-2">
                        <label class="mb-2" for="coursename"><strong>Select Course:</strong></label>
                        <select class="form-control mb-2" id="coursename" name="coursename">
                            <option value="">--Click to Select--</option>
                            <option value="frontend" disabled>Frontend</option>
                            <option value="backend">Backend</option>
                            <option value="fullstack" disabled>Fullstack</option>
                            <option value="devops" disabled>Devops</option>
                            <option value="cloud" disabled>Cloud</option>
                        </select>
                        <?php if (isset($errors["coursename"])) { ?>
                            <small class="error-message"><?php echo $errors["coursename"]; ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group mb-2">
                        <label class="mb-2" for="moduleid"><strong>Module ID:</strong></label>
                        <input type="text" class="form-control mb-2" id="moduleid" name="moduleid" value="<?php echo htmlspecialchars($invalidinputs['moduleid'] ?? ''); ?>" autocomplete="off" placeholder="Enter module ID" />
                        <?php if (isset($errors["moduleid"])) { ?>
                            <small class="error-message"><?php echo $errors["moduleid"]; ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group mb-2">
                        <label class="mb-2" for="modulename"><strong>Module Name:</strong></label>
                        <input type="text" class="form-control mb-2" id="modulename" name="modulename" value="<?php echo htmlspecialchars($invalidinputs['modulename'] ?? ''); ?>" autocomplete="off" placeholder="Enter module name" />
                        <?php if (isset($errors["modulename"])) { ?>
                            <small class="error-message"><?php echo $errors["modulename"]; ?></small>
                        <?php } ?>
                    </div>
                    <button type="submit" name="submitsmoduleForm" class="float-end btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- New Chapter Modal -->
<div class="modal fade" id="createChapterModal" tabindex="-1" aria-labelledby="createChapterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createChapterModalLabel"><strong>Module Chapter</strong> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="chapterForm" name="chapterForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group mb-2">
                        <label class="mb-2" for="coursename"><strong>Select Course:</strong></label>
                        <select class="form-control mb-2" id="coursename" name="coursename">
                            <option value="">--Click to Select--</option>
                            <option value="frontend" disabled>Frontend</option>
                            <option value="backend">Backend</option>
                            <option value="fullstack" disabled>Fullstack</option>
                            <option value="devops" disabled>Devops</option>
                            <option value="cloud" disabled>Cloud</option>
                        </select>
                        <?php if (isset($errors["coursename"])) { ?>
                            <small class="error-message"><?php echo $errors["coursename"]; ?></small>
                        <?php } ?>
                    </div>
                    <div class=" form-group">
                        <label class="mb-2" for="modulename"><strong>Select Module::</strong></label>
                        <select class="form-control mb-2" id="modulename" name="modulename">
                            <option value="">--Click to Select--</option>
                            <?php
                            $databaseName = "course";
                            $conn = tableOpConnection($databaseName);
                            $conn = new DbTableOps($conn);
                            $selectedcourse = "backend"; // the $selectedcourse is hardcoded but i intend to improve this using ajax
                            $moduleNameColumn = "`modulename`";
                            $moduleNameValues = $conn->retrieveMultipleValues("modules", $moduleNameColumn, $selectedcourse);
                            foreach ($moduleNameValues as $moduleName) {
                            ?>
                                <option value="<?php echo $moduleName; ?>"><?php echo ucwords($moduleName); ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <?php if (isset($errors["modulename"])) { ?>
                            <small class="error-message"><?php echo $errors["modulename"]; ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label class="mb-2" for="chapterid"><strong>Chapter ID:</strong></label>
                        <input type="text" class="form-control mb-2" id="chapterid" name="chapterid" value="<?php echo htmlspecialchars($invalidinputs['chapterid'] ?? ''); ?>" autocomplete="off" placeholder="Enter chapter ID" />
                        <?php if (isset($errors["chapterid"])) { ?>
                            <small class="error-message"><?php echo $errors["chapterid"]; ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label class="mb-2" for="chaptername"><strong>Chapter Name:</strong></label>
                        <input type="text" class="form-control mb-2" id="chaptername" name="chaptername" value="<?php echo htmlspecialchars($invalidinputs['chaptername'] ?? ''); ?>" autocomplete="off" placeholder="Enter chapter name" />
                        <?php if (isset($errors["chaptername"])) { ?>
                            <small class="error-message"><?php echo $errors["chaptername"]; ?></small>
                        <?php } ?>
                    </div>
                    <button type="submit" name="submitschapterForm" class="float-end btn btn-primary">
                        Submit
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/footer.php';
?>