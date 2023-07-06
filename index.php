<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';
$databaseName = "grade";
$connection = dbTableOpConnection($databaseName);
?>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/header.php';
?>

<!-- Success and Error Alert -->
<?php
if (isset($_GET['SuccessMessage'])) {
    $successMessage = $_GET['SuccessMessage'];
    echo '<div class="alert alert-success">' . $successMessage . '</div>';
}
?>
<?php
if (isset($_GET['ErrorMessage'])) {
    $errorMessage = $_GET['ErrorMessage'];
    echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
}
?>

<div class="row">
    <div class="fixed-left left-container pt-2">
        <h4>Enter Student Grades</h4>
        <form id="gradeForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label class="form-group mb-2" for="studentname"><strong>Name:</strong></label>
                <input type="text" class="mb-2 form-control" id="studentname" name="studentname" placeholder="Enter name" autocomplete="off">
            </div>
            <div class="form-group mb-2">
                <label class="form-group mb-2" for="coursename"><strong>Select Course:</strong></label>
                <select class="mb-2 form-control" id="coursename" name="coursename">
                    <option value="">--Click to Select--</option>
                    <option value="frontend">Frontend</option>
                    <option value="backend">Backend</option>
                    <option value="fullstack">Fullstack</option>
                    <option value="devops">Devops</option>
                    <option value="cloud">Cloud</option>
                </select>
            </div>
            <div class="form-group mb-2">
                <label class="form-group mb-2" for="module"><strong>Module:</strong></label>
                <select class="mb-2 form-control" id="module" name="module">
                    <option value="">--Click to Select--</option>
                    <option value=""> </option>
                </select>
            </div>
            <div class="form-group mb-2">
                <label class="form-group mb-2" for="exerciseScore"><strong>Exercise Score:</strong></label>
                <input type="text" class="mb-2 form-control" id="exerciseScore" name="exerciseScore" placeholder="Enter Score" autocomplete="off">
            </div>
            <div class="form-group mb-2">
                <label class="form-group mb-2" for="projectScore"><strong>Project Score:</strong></label>
                <input type="text" class="mb-2 form-control" id="projectScore" name="projectScore" placeholder="Enter Score" autocomplete="off">
            </div>
            <div class="form-group float-end mb-4 pt-4">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <div class="fixed-right right-container pt-2">
        <div class="flex">
            <div class="flex-left">
                <strong>
                    <h4>Download Student Report</h4>
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
                            <div class="moduleExerciseScores"><strong>Exercise Scores:</strong> <?php echo ""; ?></div>
                            <div class="moduleProjectScores"><strong>Project Scores:</strong> <?php echo ""; ?></div>

                            <div class="courseGrade"><strong>Course Grade:</strong> <?php echo "" ?>/10</div>
                            <div class="overallScore"><strong>Overall Score (Module):</strong> <?php echo "" ?></div>
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