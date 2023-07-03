<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';
$connection = connection();
?>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/header.php';
?>

<div class="row">
    <div class="fixed-left left-container">
        <h4></h4>
    </div>
    <div class="fixed-right right-container">
        <h4></h4>
        <div id="studentReport">
            <!-- student report will be dynamically generated here -->
            <?php
            if (!empty($validrecords)) {
                foreach ($validrecords as $record) {
            ?>
                    <div class="report-card">
                        <div class="report-header">
                            <div class="report-name"><?php echo ""; ?></div>
                            <div class="report-rating"><strong>Rating:</strong> <?php echo ""; ?>/5</div>
                            <div class="revport-date"><strong>Date:</strong> <?php echo "" ?></div>
                        </div>
                        <div class="report-text"><?php echo ""; ?></div>
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

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/footer.php';
?>