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
    /** ADD STUDENT FORM */
    if (filter_has_var(INPUT_POST, 'submitstudentForm')) {
        // Student Form Processing
        $studentErrors = []; // Declare an error array variable
        $studentValidInputs = []; // Declare an empty  array to store valid form fields
        $studentInvalidInputs = []; // Declare an empty  array to store invalid form fields

        /** Studentname field */
        $regpattern = '/^[A-Za-z]+(?:\s+[A-Za-z]+)*$/';
        $studentname = filter_input(INPUT_POST, 'studentname', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($studentname !== false && $studentname !== null) {
            $studentValidInputs['studentname'] = ucwords($studentname);
        } else {
            $studentErrors['studentname'] = "Name cannot contain numbers or non-alphabetic characters";
            $studentInvalidInputs['studentname'] = $studentname;
        }

        /**Coursename field */
        $courseoptions = array("frontend", "backend", "fullstack", "devops", "cloud");
        $coursename = filter_input(INPUT_POST, 'coursename', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($coursename !== null && in_array($coursename, $courseoptions)) {
            $studentValidInputs['coursename'] = $coursename;
        } else {
            $studentErrors['coursename'] = "Please select a valid course";
            $studentInvalidInputs['coursename'] = $coursename;
        }

        if (!empty($studentErrors)) {
            // Redirect to admin page with error message
            $errorMessage = "Invalid Entries";
            $_SESSION['errorMessage'] = $errorMessage;
            $_SESSION['studentErrors'] = $studentErrors;
            $_SESSION['studentInvalidInputs'] = $studentInvalidInputs;
            header('Location: admin.php');
            exit();
        }
        // Submits Form Data
        $regNo = time();
        $studentValidInputs['regno.'] = $regNo; // Assign registration number
        var_dump($studentValidInputs);
        $databaseName = "student";
        $conn = tableOpConnection($databaseName);
        $tableName = $databaseName . "." . $studentValidInputs['coursename'];
        $status = $conn->createRecords($tableName, $studentValidInputs);
        if ($status) {
            // Redirect to admin page with success message
            $successMessage = "Entry Added Successfully";
            $_SESSION['successMessage'] = $successMessage;
            header('Location: admin.php');
            exit();
        }
    }

    /** ADD MODULE FORM */
    if (filter_has_var(INPUT_POST, 'submitsmoduleForm')) {
        // Module Form Processing
        $moduleErrors = []; // Declare an error array variable
        $moduleValidInputs = []; // Declare an empty  array to store valid form fields
        $moduleInvalidInputs = []; // Declare an empty  array to store invalid form fields

        /**Coursename field */
        $courseoptions = array("frontend", "backend", "fullstack", "devops", "cloud");
        $coursename = filter_input(INPUT_POST, 'coursename', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($coursename !== null && in_array($coursename, $courseoptions)) {
            $moduleValidInputs['coursename'] = $coursename;
        } else {
            $moduleErrors['coursename'] = "Please select a valid course";
            $moduleInvalidInputs['coursename'] = $coursename;
        }

        /** ModuleID field */
        $regpattern = '/^[A-Za-z]+[\s]{1}[\d]{1,2}$/';
        $moduleid = filter_input(INPUT_POST, 'moduleid', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($moduleid !== false && $moduleid !== null) {
            $moduleValidInputs['moduleid'] = $moduleid;
        } else {
            $moduleErrors['moduleid'] = "Invalid Module ID";
            $moduleInvalidInputs['moduleid'] = $moduleid;
        }

        /**Modulename field */
        $regpattern = '/^[a-zA-Z\s]+$/';
        $modulename = filter_input(INPUT_POST, 'modulename', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($modulename !== false && $modulename !== null) {
            $moduleValidInputs['modulename'] = ucwords($modulename);
        } else {
            $moduleErrors['modulename'] = "Please select a valid module";
            $moduleInvalidInputs['modulename'] = $modulename;
        }

        if (!empty($moduleErrors)) {
            // Redirect to admin page with error message
            $errorMessage = "Invalid Entries";
            $_SESSION['errorMessage'] = $errorMessage;
            $_SESSION['moduleErrors'] = $moduleErrors;
            $_SESSION['moduleInvalidInputs'] = $moduleInvalidInputs;
            header('Location: admin.php');
            exit();
        }
        // Submits Form Data
        $databaseName = "course";
        $conn = tableOpConnection($databaseName);
        $tableName = "modules";
        $status = $conn->createRecords("`$tableName`", $moduleValidInputs);
        if ($status) {
            // Redirect to admin page with success message
            $successMessage = "Entry Added Successfully";
            $_SESSION['successMessage'] = $successMessage;
            header('Location: admin.php');
            exit();
        }
    }

    /** ADD CHAPTER FORM */
    if (filter_has_var(INPUT_POST, 'submitschapterForm')) {
        // Chapter Form Validation and Processing
        $chapterErrors = []; // Declare an error array variable
        $chapterValidInputs = []; // Declare an empty  array to store valid form fields
        $chapterInvalidInputs = []; // Declare an empty  array to store invalid form fields

        /**Coursename field */
        $courseoptions = array("frontend", "backend", "fullstack", "devops", "cloud");
        $coursename = filter_input(INPUT_POST, 'coursename', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($coursename !== null && in_array($coursename, $courseoptions)) {
            $chapterValidInputs['coursename'] = $coursename;
        } else {
            $chapterErrors['coursename'] = "Please select a valid course";
            $chapterInvalidInputs['coursename'] = $coursename;
        }

        /** Modulename field */
        $databaseName = "course";
        $conn = tableOpConnection($databaseName);
        global $coursename;
        $selectedcourse = $coursename;
        $fieldName = "`modulename`";
        $comparefieldName = "`coursename`";
        $moduleoptions = $conn->retrieveMultipleValues("modules", $fieldName, $comparefieldName, $selectedcourse);
        $modulename = filter_input(INPUT_POST, 'modulename', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($modulename !== null && in_array($modulename, $moduleoptions)) {
            $chapterValidInputs['modulename'] = $modulename;
        } else {
            $chapterErrors['modulename'] = "Please select a valid module";
            $chapterInvalidInputs['modulename'] = $modulename;
        }

        /** ChapterID field */
        $regpattern = '/^[a-zA-Z-]{3}[\d]{1}\.[a-zA-Z-][\d]{1,2}[:]$/';
        $chapterid = filter_input(INPUT_POST, 'chapterid', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($chapterid !== false && $chapterid !== null) {
            $chapterValidInputs['chapterid'] = $chapterid;
        } else {
            $chapterErrors['chapterid'] = "Invalid! ChapterID can contain cap. letters and numbers only";
            $chapterInvalidInputs['chapterid'] = $chapterid;
        }

        /** Chaptername field */
        $regpattern = '/^[a-zA-Z\s,]+$/';
        $chaptername = filter_input(INPUT_POST, 'chaptername', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($chaptername !== false && $chaptername !== null) {
            $chapterValidInputs['chaptername'] = ucwords($chaptername);
        } else {
            $chapterErrors['chaptername'] = "Please enter a valid chapter name";
            $chapterInvalidInputs['chaptername'] = $chaptername;
        }

        if (!empty($chapterErrors)) {
            // Redirect to admin page with error message
            $errorMessage = "Invalid Entries";
            $_SESSION['errorMessage'] = $errorMessage;
            $_SESSION['chapterErrors'] = $chapterErrors;
            $_SESSION['chapterInvalidInputs'] = $chapterInvalidInputs;
            header('Location: admin.php');
            exit();
        }
        // Submits Form Data
        $databaseName = "module";
        $conn = tableOpConnection($databaseName);
        $tableName = "chapters";
        $status = $conn->createRecords("`$tableName`", $chapterValidInputs);
        if ($status) {
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
        Add Student
    </button>
    <!-- Module Button trigger modal -->
    <button type="button" class="btn btn-primary my-3 mb-3" data-bs-toggle="modal" data-bs-target="#createModuleModal">
        Add Module
    </button>
    <!-- Chapter Button trigger modal -->
    <button type="button" class="btn btn-primary my-3 mb-3" data-bs-toggle="modal" data-bs-target="#createChapterModal">
        Add Chapter
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
            $tableName = "backend"; //  Hardcoded, will be mproved in the future using ajax
            // displays table based on tablename
            $conn = tableOpConnection($databaseName);
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
                        <input type="text" class="form-control mb-2" id="studentname" name="studentname" value="<?php echo htmlspecialchars($_SESSION['studentInvalidInputs']['studentname'] ?? ''); ?>" autocomplete="off" placeholder="Enter name" />
                        <?php if (isset($_SESSION['studentErrors']['studentname'])) { ?>
                            <small class="error-message"><?php echo htmlspecialchars($_SESSION['studentErrors']['studentname']); ?></small>
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
                        <?php if (isset($_SESSION['studentErrors']['coursename'])) { ?>
                            <small class="error-message"><?php echo htmlspecialchars($_SESSION['studentErrors']['coursename']); ?></small>
                        <?php } ?>
                    </div>
                    <?php
                    unset($_SESSION['studentInvalidinputs']);
                    unset($_SESSION['studentErrors']);
                    ?>
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
                        <?php if (isset($_SESSION['moduleErrors']['coursename'])) { ?>
                            <small class="error-message"><?php echo htmlspecialchars($_SESSION['moduleErrors']['coursename']); ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group mb-2">
                        <label class="mb-2" for="moduleid"><strong>Module ID:</strong></label>
                        <input type="text" class="form-control mb-2" id="moduleid" name="moduleid" value="<?php echo htmlspecialchars($_SESSION['moduleInvalidInputs']['moduleid'] ?? ''); ?>" autocomplete="off" placeholder="Enter module ID" />
                        <?php if (isset($_SESSION['moduleErrors']['moduleid'])) { ?>
                            <small class="error-message"><?php echo htmlspecialchars($_SESSION['moduleErrors']['moduleid']); ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group mb-2">
                        <label class="mb-2" for="modulename"><strong>Module Name:</strong></label>
                        <input type="text" class="form-control mb-2" id="modulename" name="modulename" value="<?php echo htmlspecialchars($_SESSION['moduleInvalidInputs']['modulename'] ?? ''); ?>" autocomplete="off" placeholder="Enter module name" />
                        <?php if (isset($_SESSION['moduleErrors']['modulenane'])) { ?>
                            <small class="error-message"><?php echo htmlspecialchars($_SESSION['moduleErrors']['modulename']); ?></small>
                        <?php } ?>
                    </div>
                    <?php
                    unset($_SESSION['moduleInvalidInputs']);
                    unset($_SESSION['moduleErrors']);
                    ?>
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
                        <?php if (isset($_SESSION['studentErrors'])) { ?>
                            <small class="error-message"><?php echo htmlspecialchars($_SESSION['studentErrors']['coursename']); ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label class="mb-2" for="modulename"><strong>Select Module:</strong></label>
                        <select class="form-control mb-2" id="modulename" name="modulename">
                            <option value="">--Click to Select--</option>
                            <?php
                            $databaseName = "course";
                            $conn = tableOpConnection($databaseName);
                            $fieldName = "`modulename`";
                            $comparefieldName = "`coursename`";
                            $selectedCourse = "backend"; // Hardcoded, i intend to improve this in future using ajax
                            $fieldNameValues = $conn->retrieveMultipleValues("modules", $fieldName, $comparefieldName, $selectedCourse);
                            foreach ($fieldNameValues as $values) {
                                echo '<option value="' . ucwords($values) . '">' . ucwords($values) . '</option>';
                            }
                            ?>
                        </select>
                        <?php if (isset($_SESSION['chapterErrors']['modulename'])) { ?>
                            <small class="error-message"><?php echo $_SESSION['chapterErrors']['modulename']; ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label class="mb-2" for="chapterid"><strong>Chapter ID:</strong></label>
                        <input type="text" class="form-control mb-2" id="chapterid" name="chapterid" value="<?php echo htmlspecialchars($_SESSION['chapterInvalidInputs']['chapterid'] ?? ''); ?>" autocomplete="off" placeholder="Enter chapter ID" />
                        <?php if (isset($_SESSION['chapterErrors']['chapterid'])) { ?>
                            <small class="error-message"><?php echo $_SESSION['chapterErrors']['chapterid']; ?></small>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label class="mb-2" for="chaptername"><strong>Chapter Name:</strong></label>
                        <input type="text" class="form-control mb-2" id="chaptername" name="chaptername" value="<?php echo htmlspecialchars($_SESSION['chapterInvalidInputs']['chaptername'] ?? ''); ?>" autocomplete="off" placeholder="Enter chapter name" />
                        <?php if (isset($_SESSION['chapterErrors']['chaptername'])) { ?>
                            <small class="error-message"><?php echo $_SESSION['chapterErrors']['chaptername']; ?></small>
                        <?php } ?>
                    </div>
                    <?php
                    unset($_SESSION['chapterInvalidInputs']);
                    unset($_SESSION['chapterErrors']);
                    ?>
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