<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';
$databaseName = "``";
$connection = dbTableOpConnection($databaseName);
?>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/header.php';
/**
 * Student Records Management System
 * Takes student assessment and project scores per module
 * Calculates module grade and overall score
 */
?>

<div class="row">
    <div class="fixed-left left-container">
        <strong>
            <h4>Student Records</h4>
        </strong>
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

        <div class="btn-grp">
            <!-- Create Grade-Record Button trigger modal -->
            <button type="button" class="btn btn-success rounded my-3 mb-3" data-toggle="modal" data-target="#gradeModal">
                Add Student Grade
            </button>

            <!-- Dropdown -->
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    View Class Records
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-table">All</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-table">Frontend</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-table">Backend</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-table">Fullstack</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-table">Devops</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-table">Cloud</a>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed-right right-container">
        <strong>
            <h4>Student Report</h4>
        </strong>
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
                            <div class="studentClass"><strong>Class:</strong> <?php echo ""; ?></div>

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

<!--Add Grade Modal -->
<div class="modal fade" id="gradeModal" tabindex="-1" role="dialog" aria-labelledby="gradeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gradeModalLabel">Grade Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="gradeForm" method="post" action="">
                    <div class="form-group">
                        <label for="name"><strong>Name:</strong></label>
                        <input type="text" class=" form-control" id="name" name="name" placeholder="Enter name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="class"><strong>Class:</strong></label>
                        <select class="form-control" id="class" name="class">
                            <option value="">--Click to Select--</option>
                            <option value="frontend">Frontend Engineer</option>
                            <option value="backend">Backend Engineer</option>
                            <option value="fullstack">Fullstack Engineer</option>
                            <option value="devops">Devops Engineer</option>
                            <option value="cloud">Cloud Engineer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="module"><strong>Module:</strong></label>
                        <select class="form-control" id="module" name="module">
                            <option value="">--Click to Select--</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exerciseScore"><strong>Exercise Score:</strong></label>
                        <input type="text" class=" form-control" id="exerciseScore" name="exerciseScore" placeholder="Enter Score" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="projectScore"><strong>Project Score:</strong></label>
                        <input type="text" class=" form-control" id="projectScore" name="projectScore" placeholder="Enter Score" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Display Class Modal -->
<div class="modal fade" id="modal-table" tabindex="-1" role="dialog" aria-labelledby="tableModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tableModalLabel">Class Records</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body scrollable-container">
                <section class="wrapper-main">
                    <!-- List Class Record -->
                    <div class="container-fluid table-wrapper">
                        <table class="table table-striped table-bordered mt-4">
                            <thead class="thead-dark">
                                <tr>
                                    <th>S/n</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th colspan="2">Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $records = $connection->retrieveAllRecords("");
                                if (!empty($records)) {
                                    $count = 0;
                                    foreach ($records as $row) {
                                        $count++;
                                ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $row[""]; ?></td>
                                            <td><?php echo $row[""]; ?></td>
                                            <td><?php echo $row[""]; ?></td>
                                            <td><?php echo $row[""]; ?></td>
                                            <td><?php echo $row[""]; ?></td>
                                            <td><?php echo $row[""]; ?></td>
                                            <td><?php echo $row[""]; ?></td>
                                            <td><?php echo $row[""]; ?></td>
                                            <td><?php echo $row[""]; ?></td>
                                            <td><?php echo $row[""]; ?></td>
                                            <td class="btn-group">
                                                <a href="index.php?" class="btn btn-success rounded btn-sm">Update</a>
                                                <a href="index.php?" class="btn btn-primary rounded btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="13">No records found.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/footer.php';
?>