<?php
session_start();

session_destroy();

session_unset();
// Redirect to index page
header('Location: index.php');
exit();
