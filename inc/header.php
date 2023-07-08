<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css" />
    <title>Jagaad Academy</title>
</head>

<body class="container pt-4 pr-3 pb-4 pl-3 mt-4 mb-4">
    <header class="flex fixed-top bg-secondary my-1 py-3">
        <!-- Nav -->
        <nav class="flex-left btn-grp">
            <a href="./" class="btn text-white ml-5 mr-5"><strong>HOME</strong></a>
            <a href="./about.php" class="btn text-white ml-5 mr-5" onclick="event.preventDefault()"><strong>ABOUT US</strong></a>
            <a href="./academics.php" class="btn text-white ml-5 mr-5" onclick="event.preventDefault()"><strong>ACADEMICS</strong></a>
            <a href="./units.php" class="btn text-white ml-5 mr-5" onclick="event.preventDefault()"><strong>UNITS</strong></a>
            <a href="./research.php" class="btn text-white ml-5 mr-5" onclick="event.preventDefault()"><strong>RESEARCH</strong></a>
            <a href="./resources.php" class="btn text-white ml-5 mr-5" onclick="event.preventDefault()"><strong>RESOURCES</strong></a>
            <a href="./donations.php" class="btn text-white ml-5 mr-5" onclick="event.preventDefault()"><strong>DONATIONS</strong></a>
        </nav>

        <?php
        $pageview = basename($_SERVER['PHP_SELF']) === 'admin.php' ? 'Home' : 'Admin';
        $pagelink = ($pageview === 'Home') ? "index" : strtolower("Admin");
        ?>
        <a href="./<?php echo $pagelink; ?>.php" class="flex-right btn text-white"><strong><?php echo $pageview; ?></strong></a>
    </header>

    <main class="my-2 pt-3">