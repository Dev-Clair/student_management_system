<?php
// Import file containing functions for validating userinput
require_once "validate_userinput.php";

$filePath = __DIR__ . DIRECTORY_SEPARATOR . 'database.json';

// Read the database file
$data = file_get_contents($filePath);
$members = json_decode($data, true);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data and clean the values using clean_name/class/grade functions
    $name = clean_name($_POST['name']);
    $class = clean_class($_POST['class']);
    $grade = clean_grade($_POST['grade']);

    // Validate userinput using the validate_name/class/grade functions
    if (!validate_name($name) || !validate_class($class) || !validate_grade($grade)) {
        // Display error message and redirect to index.php after 5 seconds
        header('Refresh: 5; URL=index.php');
        echo "Oops! Something went wrong and we couldn't add the record. Make sure you follow the help-info and grade must be between 0-10 when you try again";
        exit;
    }

    // Generate the registration number using the time() function
    $regNo = time(); // The registration number will serve as the database primary key

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

    // Redirect back to index.php with success message
    $address = 'index.php?success=1';
    redirect_to($address);
    exit;
}
