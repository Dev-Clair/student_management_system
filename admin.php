<?php
// require resource: Connection Object
require_once __DIR__ . DIRECTORY_SEPARATOR . './DbConnection/dbConnection.php';
$connection = connection();
?>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/header.php';
?>

<body class="container-fluid">
    <main>
        <h1>Admin</h1>
    </main>

    <?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/footer.php';
    ?>