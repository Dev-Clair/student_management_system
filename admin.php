<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';
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
            $databaseName = "student";
            $connection = tableConnection($databaseName);
            // $tableNames = $connection->retrieveTableNames($databaseName);
            // $tableName = $tableNames[0];
            // displays table based on tablename
            $connection = dbTableOpConnection($databaseName);
            // $records = $connection->retrieveAllRecords("$tableName");
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
                <form id="classForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
                    <button type="submit" class="float-end btn btn-primary">
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
                <form id="moduleForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group mb-2">
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
                    <div class="form-group mb-2">
                        <label class="mb-2" for="moduleid"><strong>Module ID:</strong></label>
                        <input type="text" class="form-control mb-2" id="moduleid" name="moduleid" autocomplete="off" placeholder="Enter module ID" />
                    </div>
                    <div class="form-group mb-2">
                        <label class="mb-2" for="modulename"><strong>Module Name:</strong></label>
                        <input type="text" class="form-control mb-2" id="modulename" name="modulename" autocomplete="off" placeholder="Enter module name" />
                    </div>
                    <button type="submit" class="float-end btn btn-primary">Submit</button>
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
                <form id="moduleForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class=" form-group">
                        <label class="mb-2" for="modulename"><strong>Select Module::</strong></label>
                        <select class="form-control mb-2" id="modulename" name="modulename">
                            <option value="">--Click to Select--</option>
                            <?php
                            $databaseName = "course";
                            $connection = dbTableOpConnection($databaseName);
                            $moduleNameColumn = "`modulename`";
                            // $moduleNameValues = $connection->retrieveColumnValues("`modules`", $moduleNameColumn);
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
                    <button type="submit" class="float-end btn btn-primary">
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