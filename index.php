<?php

// Import file containing functions for validating userinput
require_once "validate_userinput.php";

$filePath = __DIR__ . DIRECTORY_SEPARATOR . 'database.json';

// Read the database file
$data = file_get_contents($filePath);
$members = json_decode($data, true);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data and clean the values using the trim and strip_tags functions
    $name = clean_name($_POST['name']);
    $class = clean_class($_POST['class']);
    $grade = clean_grade($_POST['grade']);

    // Generate the registration number using the time() function
    $regNo = time(); // The registration number will serve as the student's primary key

    // Create a new member record
    $newMember = array(
        'name' => $name,
        'class' => $class,
        'regNo' => $regNo,
        'grade' => $grade
    );

    // Add the new member to the array
    $members[] = $newMember;

    // Save the updated records back to the file
    $updatedRecord = json_encode($members, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $updatedRecord);

    // Redirect back to index.php
    $address = 'index.php';
    redirect_to($address);
    exit;
}

// Check if the delete action is requested
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['regNo'])) {
    $regNo = $_GET['regNo'];

    // Search for the member with the matching registration number
    foreach ($members as $key => $member) {
        if ($member['regNo'] == $regNo) {
            // Remove the existing member record
            unset($members[$key]);
            break;
        }
    }

    // Save the updated records back to the file
    $updatedRecord = json_encode($members, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $updatedRecord);

    // Redirect back to index.php
    $address = 'index.php';
    redirect_to($address);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Student Records</title>
</head>

<body class="my-5 mb-5">

    <div class="container">
        <div class="float-end mt-2">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newStudentModal">
                New Student
            </button>
        </div>
    </div>

    <section class="wrapper-main">
        <!-- List student record -->
        <div class="container table-wrapper">
            <table class="table table-striped table-bordered mt-4">
                <thead class="thead-dark">
                    <tr>
                        <th>S/n</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Reg. No.</th>
                        <th>Grade</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($members)) {
                        $count = 0;
                        foreach ($members as $row) {
                            $count++;
                    ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["class"]; ?></td>
                                <td><?php echo $row["regNo"]; ?></td>
                                <td><?php echo $row["grade"]; ?></td>
                                <td>
                                    <a href="update.php?regNo=<?php echo $row["regNo"]; ?>" class="btn btn-primary btn-sm">Update</a>
                                    <a href="index.php?action=delete&regNo=<?php echo $row["regNo"]; ?>" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6">No records found.</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- New Student Modal -->
    <div class="modal fade" id="newStudentModal" tabindex="-1" aria-labelledby="newStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newStudentModalLabel"><strong>New Student Record</strong> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="index.php">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="form-label"><strong>Name:</strong></label>
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <p><em>First and Last Names Only</em> </p>
                        </div>
                        <!-- Class Field -->
                        <div>
                            <label for="class" class="form-label"><strong>Class:</strong></label>
                            <input type="text" class="form-control" id="class" name="class" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <p><em>Stem | Commerce | Art</em> </p>
                        </div>
                        <!-- Grade Field -->
                        <div class="mb-3">
                            <label for="grade" class="form-label">
                                <strong>Grade:</strong>
                            </label>
                            <input type="number" class="form-control" id="grade" name="grade" autocomplete="off">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>