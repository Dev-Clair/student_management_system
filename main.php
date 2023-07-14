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

require_once  __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gradeErrors = []; // Declare an error array variable
    $gradeValidInputs = []; // Declare an empty  array to store valid form fields
    $gradeInvalidInputs = []; // Declare an empty  array to store invalid form fields
    if (filter_has_var(INPUT_POST, 'submitsgradeForm')) {
        // Grade Form Processing

        /** Studentname field */
        $regpattern = '/^[A-Za-z]+(?:\s+[A-Za-z]+)*$/';
        $studentname = filter_input(INPUT_POST, 'studentname', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($studentname !== false && $studentname !== null) {
            $gradeValidInputs['studentname'] = ucwords($studentname);
        } else {
            $gradeErrors['studentname'] = "Name cannot contain numbers or non-alpahbetic characters";
            $gradeInvalidInputs['studentname'] = $studentname;
        }

        /**Coursename field */
        $courseoptions = array("frontend", "backend", "fullstack", "devops", "cloud");
        $coursename = filter_input(INPUT_POST, 'coursename', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($coursename !== null && in_array($coursename, $courseoptions)) {
            $gradeValidInputs['coursename'] = $coursename;
        } else {
            $gradeErrors['coursename'] = "Please select a valid course";
            $gradeInvalidInputs['coursename'] = $coursename;
        }

        /**Modulename field */
        $regpattern = '/^[a-zA-Z\s]+$/';
        $modulename = filter_input(INPUT_POST, 'modulename', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($modulename !== false && $modulename !== null) {
            $gradeValidInputs['modulename'] = ucwords($modulename);
        } else {
            $gradeErrors['modulename'] = "Please select a valid module";
            $gradeInvalidInputs['modulename'] = $modulename;
        }

        /** Chaptername field */
        $regpattern = '/^[a-zA-Z\s]+$/';
        $chaptername = filter_input(INPUT_POST, 'chaptername', FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regpattern)
        ));

        if ($chaptername !== false && $chaptername !== null) {
            $gradeValidInputs['chaptername'] = ucwords($chaptername);
        } else {
            $gradeErrors['chaptername'] = "Please enter a valid chapter name";
            $gradeInvalidInputs['chaptername'] = $chaptername;
        }

        /** Exercise Score field */
        $scoreoptions = array("min-value" => 0, "max-value" => 10);
        $exercisescore = filter_input(INPUT_POST, 'exercisescore', FILTER_VALIDATE_INT, array('options' => $scoreoptions));

        if ($exercisescore !== false && $exercisescore !== null) {
            // Variable is valid
            $gradeValidInputs['exercisescore'] = $exercisescore;
        } elseif ($exercisescore === null) {
            // Variable not set
            $gradeErrors['exercisescore'] = "Please enter a score";
        } else {
            // Variable is invalid
            $gradeErrors['exercisescore'] = "Please enter a valid score (0-10)";
            $gradeInvalidInputs['exercisescore'] = $exercisescore;
        }

        /** Project Score field */
        $scoreoptions = array("min-value" => 0, "max-value" => 100);
        $projectscore = filter_input(INPUT_POST, 'projectscore', FILTER_VALIDATE_INT, array('options' => $scoreoptions));

        if ($projectscore !== false && $projectscore !== null) {
            // Variable is valid
            $gradeValidInputs['projectscore'] = $projectscore;
        } elseif ($exercisescore === null) {
            // Variable not set
            $gradeErrors['projectscore'] = "Please enter a score";
        } else {
            // Variable is invalid
            $gradeErrors['projectscore'] = "Please enter a valid score (0-100)";
            $gradeInvalidInputs['projectscore'] = $projectscore;
        }

        if (!empty($gradeErrors)) {
            // Redirect to main page with error message
            $errorMessage = "Invalid Entries";
            $_SESSION['errorMessage'] = $errorMessage;
            $_SESSION['gradeErrors'] = $gradeErrors;
            $_SESSION['gradeValidInputs'] = $gradeValidInputs;
            $_SESSION['gradeInvalidInputs'] = $gradeInvalidInputs;
            header('Location: main.php');
            exit();
        }
        // Submits Form Data
        $databaseName = "grade";
        $conn = tableOpConnection($databaseName);
        $tableName = $gradeValidInputs['coursename'];
        $status = $conn->createRecords("$tableName", $gradeValidInputs);
        if ($status) {
            // Redirect to main page with success message
            $successMessage = "Entries Added Successfully";
            $_SESSION['successMessage'] = $successMessage;
            header('Location: main.php');
            exit();
        }
    }
    // Redirect to main page with error message
    $errorMessage = "Error! Process failed, Please try again.";
    $_SESSION['errorMessage'] = $errorMessage;
    header('Location: main.php');
    exit();
}
?>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/header.php';
?>

<div class="row">
    <!-- Success and Error Alert -->
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
    <div class="fixed-left left-container pt-2">
        <h4>Student Grade</h4>
        <form id="gradeForm" name="gradeForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label class="form-group mb-2" for="studentname"><strong>Name:</strong></label>
                <input type="text" class="mb-2 form-control" id="studentname" name="studentname" value="<?php echo htmlspecialchars($_SESSION['gradeInvalidInputs']['studentname'] ?? ''); ?>" placeholder="Enter Name" autocomplete="off">
                <?php if (isset($_SESSION['gradeErrors']['studentname'])) { ?>
                    <small class="error-message"><?php echo htmlspecialchars($_SESSION['gradeErrors']['studentname']); ?></small>
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
                <?php if (isset($_SESSION['gradeErrors']['coursename'])) { ?>
                    <small class="error-message"><?php echo htmlspecialchars($_SESSION['gradeErrors']['gradeErrors']['coursename']); ?></small>
                <?php } ?>
            </div>
            <div class="form-group mb-2">
                <label class="form-group mb-2" for="module"><strong>Select Module:</strong></label>
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
                <?php if (isset($_SESION['gradeErrors']['modulename'])) { ?>
                    <small class="error-message"><?php echo htmlspecialchars($_SESSION['gradeErrors']['modulename']); ?></small>
                <?php } ?>
            </div>
            <div class="form-group mb-2">
                <label class="form-group mb-2" for="chapter"><strong>Select Chapter:</strong></label>
                <select class="form-control mb-2" id="chaptername" name="chaptername">
                    <option value="">--Click to Select--</option>
                    <?php
                    $databaseName = "module";
                    $conn = tableOpConnection($databaseName);
                    $fieldName = "`chaptername`";
                    $comparefieldName = "`coursename`";
                    $selectedCourse = "backend"; // Hardcoded, i intend to improve this in future using ajax
                    $fieldNameValues = $conn->retrieveMultipleValues("chapters", $fieldName, $comparefieldName, $selectedCourse);
                    foreach ($fieldNameValues as $values) {
                        echo '<option value="' . ucwords($values) . '">' . ucwords($values) . '</option>';
                    }
                    ?>
                </select>
                <?php if (isset($errors["chaptername"])) { ?>
                    <small class="error-message"><?php echo $errors["chaptername"]; ?></small>
                <?php } ?>
            </div>
            <div class="form-group mb-2">
                <label class="form-group mb-2" for="exerciseScore"><strong>Exercise Score:</strong></label>
                <input type="text" class="mb-2 form-control" id="exerciseScore" name="exerciseScore" value="<?php echo htmlspecialchars($_SESSION['gradeInvalidInputs']['exercisescore'] ?? ''); ?>" placeholder="Enter exercise score" autocomplete="off">
                <?php if (isset($_SESSION['gradeErrors']['exercisescore'])) { ?>
                    <small class="error-message"><?php echo htmlspecialchars($_SESSION['gradeErrors']['exercisescore']); ?></small>
                <?php } ?>
            </div>
            <div class="form-group mb-2">
                <label class="form-group mb-2" for="projectScore"><strong>Project Score:</strong></label>
                <input type="text" class="mb-2 form-control" id="projectScore" name="projectScore" value="<?php echo htmlspecialchars($_SESSION['gradeInvalidInputs']['projectscore'] ?? ''); ?>" placeholder="Enter project score" autocomplete="off">
                <?php if (isset($_SESSION['gradeErrors']['projectscore'])) { ?>
                    <small class="error-message"><?php echo $_SERVER['gradeErrors']['projectscore']; ?></small>
                <?php } ?>
            </div>
            <?php
            unset($_SESSION['gradeInvalidInputs']);
            unset($_SESSION['gradeErrors']);
            ?>
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