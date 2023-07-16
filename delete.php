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

// Provide Connection Object
$databaseName = "student";
$conn = tableOpConnection($databaseName);

$fieldName = "regno.";
$fieldValue = (int)$_GET['studentid'] ?? null;
$tableName = $_GET['coursename'] ?? null;

$status = $conn->validateFieldValue($tableName, "`$fieldName`", $fieldValue);
if ($status !== true) {
    // Redirect to admin page with error message
    $errorMessage = "Error! Cannot Delete Record";
    $_SESSION['errorMessage'] = $errorMessage;
    header('Location: admin.php');
    exit();
}

$status = $conn->deleteRecord($tableName, "`$fieldName`", $fieldValue);
if ($status === true) {
    // Redirect to admin page with success message
    $successMessage = "Success! Record Deleted Successfully";
    $_SESSION['successMessage'] = $successMessage;
    header('Location: admin.php');
    exit();
}
// Redirect to admin page with error message
$errorMessage = "Error! Booking Not Found";
$_SESSION['errorMessage'] = $errorMessage;
header('Location: admin.php');
exit();
