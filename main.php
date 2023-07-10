<?php
session_start(); // Starts session for current script
// Retrieve Session Variables and verify loginStatus
$userID = $_SESSION['userID'];
$loginStatus = $_SESSION['loginStatus'];
if ($userID === null && $loginStatus !== false) {
    // Redirect to login page withinvalid login status
    $errorMessage = "Invalid Login Status! Please login again.";
    header('Location: index.php?errorMessage=' . urlencode($errorMessage));
    exit();
}
session_regenerate_id();

require_once  __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = []; // Declare an error array variable
    $validinputs = []; // Declare an empty  array to store valid form fields
    $invalidinputs = []; // Declare an empty  array to store invalid form fields
    if (filter_has_var(INPUT_POST, 'submitsgradeForm')) {
        // Grade Form Processing

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

        /** Exercise Score field */
        $scoreoptions = array("min-value" => 0, "max-value" => 10);
        $exercisescore = filter_input(INPUT_POST, 'exercisescore', FILTER_VALIDATE_INT, array('options' => $scoreoptions));

        if ($exercisescore !== false && $exercisescore !== null) {
            // Variable is valid
            $validinputs['exercisescore'] = $exercisescore;
        } elseif ($exercisescore === null) {
            // Variable not set
            $errors['exercisescore'] = "Please enter a score";
        } else {
            // Variable is invalid
            $errors['exercisescore'] = "Please enter a valid score (0-10)";
            $invalidinputs['exercisescore'] = $exercisescore;
        }

        /** Project Score field */
        $scoreoptions = array("min-value" => 0, "max-value" => 100);
        $projectscore = filter_input(INPUT_POST, 'projectscore', FILTER_VALIDATE_INT, array('options' => $scoreoptions));

        if ($projectscore !== false && $projectscore !== null) {
            // Variable is valid
            $validinputs['projectscore'] = $projectscore;
        } elseif ($exercisescore === null) {
            // Variable not set
            $errors['projectscore'] = "Please enter a score";
        } else {
            // Variable is invalid
            $errors['projectscore'] = "Please enter a valid score (0-100)";
            $invalidinputs['projectscore'] = $projectscore;
        }

        if (!empty($errors)) {
            // Redirect to main page with error message
            $errorMessage = "Invalid Entries";
            header('Location: main.php?errorMessage=' . urlencode($errorMessage));
            exit();
        }
        // Submits Form Data
        $databaseName = "grade";
        $conn = tableOpConnection($databaseName);
        $conn = new DbTableOps($conn);
        $tableName = $validinputs['coursename'];
        $record = $conn->createRecords("$tableName", $validinputs);
        if ($record) {
            // Redirect to main page with success message
            $successMessage = "Entries Added Successfully";
            header('Location: main.php?successMessage=' . urlencode($successMessage));
            exit();
        }
    }
    // Redirect to main page with error message
    $errorMessage = "Error! Process failed, Please try again.";
    header('Location: main.php?errorMessage=' . urlencode($errorMessage));
    exit();
}
?>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/header.php';
?>

<div class="row">
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
    <div class="fixed-left left-container pt-2">
        <h4>Student Grade</h4>
        <form id="gradeForm" name="gradeForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label class="form-group mb-2" for="studentname"><strong>Name:</strong></label>
                <input type="text" class="mb-2 form-control" id="studentname" name="studentname" value="<?php echo htmlspecialchars($invalidinputs['studentname'] ?? ''); ?>" placeholder="Enter Name" autocomplete="off">
                <?php if (isset($errors["studentname"])) { ?>
                    <small class="error-message"><?php echo $errors["studentname"]; ?></small>
                <?php } ?>
            </div>
            <div class="form-group mb-2">
                <label class="form-group mb-2" for="coursename"><strong>Select Course:</strong></label>
                <select class="mb-2 form-control" id="coursename" name="coursename">
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
                <label class="form-group mb-2" for="module"><strong>Select Module:</strong></label>
                <select class="mb-2 form-control" id="module" name="module">
                    <option value="">--Click to Select--</option>
                    <option value=""> </option>
                </select>
                <?php if (isset($errors["modulename"])) { ?>
                    <small class="error-message"><?php echo $errors["modulename"]; ?></small>
                <?php } ?>
            </div>
            <div class="form-group mb-2">
                <label class="form-group mb-2" for="chapter"><strong>Select Chapter:</strong></label>
                <select class="mb-2 form-control" id="chapter" name="chapter">
                    <option value="">--Click to Select--</option>
                    <option value=""> </option>
                </select>
                <?php if (isset($errors["chaptername"])) { ?>
                    <small class="error-message"><?php echo $errors["chaptername"]; ?></small>
                <?php } ?>
            </div>
            <div class="form-group mb-2">
                <label class="form-group mb-2" for="exerciseScore"><strong>Exercise Score:</strong></label>
                <input type="text" class="mb-2 form-control" id="exerciseScore" name="exerciseScore" value="<?php echo htmlspecialchars($invalidinputs['exercisescore'] ?? ''); ?>" placeholder="Enter exercise score" autocomplete="off">
                <?php if (isset($errors["studentname"])) { ?>
                    <small class="error-message"><?php echo $errors["exercisescore"]; ?></small>
                <?php } ?>
            </div>
            <div class="form-group mb-2">
                <label class="form-group mb-2" for="projectScore"><strong>Project Score:</strong></label>
                <input type="text" class="mb-2 form-control" id="projectScore" name="projectScore" value="<?php echo htmlspecialchars($invalidinputs['projectscore'] ?? ''); ?>" placeholder="Enter project score" autocomplete="off">
                <?php if (isset($errors["studentname"])) { ?>
                    <small class="error-message"><?php echo $errors["projectscore"]; ?></small>
                <?php } ?>
            </div>
            <div class="form-group float-end mb-4 pt-4">
                <button type="submit" name="submitsgradeForm" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <div class="fixed-right right-container pt-2">
        <div class="flex">
            <div class="flex-left">
                <strong>
                    <h4>Student Report</h4>
                </strong>
            </div>
            <div class="flex-right">
                <button class="btn btn-success btn-sm rounded" onclick="printStudentReport()">Print/Save Report</button>
            </div>
        </div>
        <div id="studentReport">
            <!-- student report will be dynamically generated here -->
            <?php
            if (!empty($validreports)) {
                foreach ($validreports as $report) {
            ?>
                    <div class="studentCard">
                        <div class="studentHeader">
                            <div class="studentName"><strong>Name:</strong><?php echo ""; ?></div>
                            <div class="studentRegNo"><strong>Reg. No.:</strong> <?php echo ""; ?></div>
                            <div class="studentCourse"><strong>Course:</strong> <?php echo ""; ?></div>

                            <div class="courseModules"><strong>Course Modules:</strong> <?php echo ""; ?>/6</div>
                            <div class="moduleExerciseScores"><strong>Exercise Score:</strong> <?php echo ""; ?>/10</div>
                            <div class="moduleProjectScores"><strong>Project Score:</strong> <?php echo ""; ?>/100</div>

                            <div class="totalGrade"><strong>Total Grade:</strong> <?php echo "" ?></div>
                            <div class="totalScore"><strong>Total Score:</strong> <?php echo "" ?></div>
                        </div>
                        <div class="studentPerformance"><strong>Overall Performance:</strong> <?php echo ""; ?></div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No records found.</p>";
            }
            ?>
        </div>
    </div>
</div>
<script>
    function printStudentReport() {
        const printContents = document.getElementById("studentReport").innerHTML;
        const originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/footer.php';
?>