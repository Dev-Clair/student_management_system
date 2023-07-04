<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';
$connection = dbTableOpConnection();
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

<!-- Class Table -->
<div class="container table-wrapper">
    <div class="float-end">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary my-3 mb-3" data-bs-toggle="modal" data-bs-target="#createClassModal">
            Create Class
        </button>
    </div>
    <table class="table table-striped table-bordered mt-4">
        <thead class="thead-dark">
            <tr>
                <th>S/n</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Action</th>
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
                    <td colspan="7">No records found.</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- New Class Modal -->
<div class="modal fade" id="createClassModal" tabindex="-1" aria-labelledby="createClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClassModalLabel"><strong>Create Service</strong> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="serviceForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <label for=""><strong></strong></label>
                        <input type="text" class="form-control mb-2" id="" name="" autocomplete="off" placeholder="" />
                    </div>
                    <div class="form-group">
                        <label for=""><strong></strong></label>
                        <input type="text" class="form-control mb-2" id="" name="" autocomplete="off" placeholder="" />
                    </div>
                    <div class="form-group">
                        <label for=""><strong></strong></label>
                        <textarea class="form-control mb-2" id="" name="" rows="3" autocomplete="off" placeholder="" maxlength="150"></textarea>
                    </div>
                    <div class=" form-group">
                        <label for=""><strong></strong></label>
                        <input type="text" class="form-control mb-2" id="" name="" autocomplete="off" placeholder="" />
                    </div>
                    <div class=" form-group">
                        <label for=""><strong></strong></label>
                        <select class="form-control mb-2" id="" name="">
                            <option value="">--Click to Select--</option>
                            <option value=""></option>
                            <option value=""></option>
                            <option value=""></option>
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

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/footer.php';
?>