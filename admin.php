<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (filter_has_var(INPUT_POST, 'submitstudentForm')) {
        // Student Form Processing
    }

    if (filter_has_var(INPUT_POST, 'submitmoduleForm')) {
        // Module Form Processing
        $errors = []; // Declare an error array variable
        $validinputs = []; // Declare an empty  array to store valid form fields
        $invalidinputs = []; // Declare an empty  array to store invalid form fields

        /**Coursename field */
        $courseoptions = array("frontend", "backend", "fullstack", "devops", "cloud");
        $coursename = filter_input(INPUT_POST, 'coursename', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($coursename !== null && in_array($coursename, $courseoptions)) {
            $validinputs['coursename'] = $coursename;
        } else {
            $errors['coursename'] = "Invalid Option";
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
            $errors['modulename'] = "Invalid Module Name";
            $invalidinputs['modulename'] = $modulename;
        }

        if (!empty($errors)) {
            // Redirect to admin page with error message
            $errorMessage = "Invalid Entries";
            header('Location: admin.php?errorMessage=' . $errorMessage);
        }
        // Submits Form Data
        $databaseName = $validinputs['coursename'];
        $conn = tableOpConnection($databaseName);
        $conn = new DbTableOps($conn);
        $tableName = "";
        $record = $conn->createRecords("$tableName", $validinputs);
        if ($record) {
            // Redirect to admin page with success message
            $successMessage = "Entry Added Successfully";
            header('Location: admin.php?successMessage=' . $successMessage);
        }
    }

    if (filter_has_var(INPUT_POST, 'submitchapterForm')) {
        // Chapter Form Validation and Processing
        $errors = []; // Declare an error array variable
        $validinputs = []; // Declare an empty  array to store valid form fields
        $invalidinputs = []; // Declare an empty  array to store invalid form fields

        /**Coursename field */
        $courseoptions = array("frontend", "backend", "fullstack", "devops", "cloud");
        $coursename = filter_input(INPUT_POST, 'coursename', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($coursename !== null && in_array($coursename, $courseoptions)) {
            $validinputs['coursename'] = $coursename;
        } else {
            $errors['coursename'] = "Invalid Option";
            $invalidinputs['coursename'] = $coursename;
        }

        // /** Modulename field */
        // $moduleoptions = null;
        // $modulename = filter_input(INPUT_POST, 'modulename', FILTER_SANITIZE_SPECIAL_CHARS);

        // if ($modulename !== null && in_array($modulename, $moduleoptions)) {
        //     $validinputs['modulename'] = $modulename;
        // } else {
        //     $errors['modulename'] = "Invalid Option";
        //     $invalidinputs['modulename'] = $modulename;
        // }

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
            $errors['chaptername'] = "Invalid Chapter Name";
            $invalidinputs['chaptername'] = $chaptername;
        }

        if (!empty($errors)) {
            // Redirect to admin page with error message
            $errorMessage = "Invalid Entries";
            header('Location: admin.php?errorMessage=' . $errorMessage);
        }
        // Submits Form Data
        $databaseName = $validinputs['coursename'];
        $conn = tableOpConnection($databaseName);
        $conn = new DbTableOps($conn);
        $tableName = "";
        $record = $conn->createRecords("$tableName", $validinputs);
        if ($record) {
            // Redirect to admin page with success message
            $successMessage = "Entry Added Successfully";
            header('Location: admin.php?successMessage=' . $successMessage);
        }
    }
}

?>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/header.php';
?>
<!-- Success and Error Alert -->
<?php
if (isset($_GET['successMessage'])) {
    $successMessage = $_GET['successMessage'];
    echo '<div class="alert alert-success">' . $successMessage . '</div>';
}
?>
<?php
if (isset($_GET['errorMessage'])) {
    $errorMessage = $_GET['errorMessage'];
    echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
}
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
            // $databaseName = "student";
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
                            <a href="update.php?" class="btn btn-primary btn-sm ms-2">Update</a>
                            <a href="admin.php?action=delete&" class="btn btn-danger btn-sm">Delete</a>
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
                        <input type="text" class="form-control mb-2" id="studentname" name="studentname" autocomplete="off" placeholder="Enter name" />
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
                            <option value="frontend">Frontend</option>
                            <option value="backend>">Backend</option>
                            <option value="fullstack">Fullstack</option>
                            <option value="devops">Devops</option>
                            <option value="cloud">Cloud</option>
                        </select>
                        <small class="alert alert-danger"><?php echo $errors['coursename'] ?? ''; ?></small>
                    </div>
                    <div class="form-group mb-2">
                        <label class="mb-2" for="moduleid"><strong>Module ID:</strong></label>
                        <input type="text" class="form-control mb-2" id="moduleid" name="moduleid" value="<?php echo $invalidinputs['moduleid'] ?? ''; ?>" autocomplete="off" placeholder="Enter module ID" />
                        <small class="alert alert-danger"><?php echo $errors['moduleid'] ?? ''; ?></small>
                    </div>
                    <div class="form-group mb-2">
                        <label class="mb-2" for="modulename"><strong>Module Name:</strong></label>
                        <input type="text" class="form-control mb-2" id="modulename" name="modulename" value="<?php echo $invalidinputs['modulename'] ?? ''; ?>" autocomplete="off" placeholder="Enter module name" />
                        <small class="alert alert-danger"><?php echo $errors['modulename'] ?? ''; ?></small>
                    </div>
                    <button type="submit" name="submitmoduleForm" class="float-end btn btn-primary">Submit</button>
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
                    <div class=" form-group">
                        <label class="mb-2" for="modulename"><strong>Select Module::</strong></label>
                        <select class="form-control mb-2" id="modulename" name="modulename">
                            <option value="">--Click to Select--</option>
                            <?php
                            $databaseName = "course";
                            $conn = tableOpConnection($databaseName);
                            $conn = new DbTableOps($conn);
                            $moduleNameColumn = "`modulename`";
                            $moduleNameValues = $conn->retrieveColumnValues("modules", $moduleNameColumn);
                            foreach ($moduleNameValues as $moduleName) {
                            ?>
                                <option value="<?php echo $moduleName; ?>"><?php echo $moduleName; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="mb-2" for="chapterid"><strong>Chapter ID:</strong></label>
                        <input type="text" class="form-control mb-2" id="chapterid" name="chapterid" autocomplete="off" placeholder="Enter chapter ID" />
                    </div>
                    <div class="form-group">
                        <label class="mb-2" for="chaptername"><strong>Chapter Name:</strong></label>
                        <input type="text" class="form-control mb-2" id="chaptername" name="chaptername" autocomplete="off" placeholder="Enter chapter name" />
                    </div>
                    <button type="submit" name="submitchapterForm" class="float-end btn btn-primary">
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