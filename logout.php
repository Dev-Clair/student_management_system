<?php
session_start();

session_destroy();

session_unset();
// Redirect to index page with logout message
$logoutMessage = "Logged Out Successfully";
header('Location: index.php?logoutMessage=' . $logoutMessage);
exit();
