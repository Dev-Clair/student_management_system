<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'dbConnection.php';
$connection = connection();
?>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/header.php';
?>

<div class="row">
    <div id="reviewSubmission" class="fixed-left left-container">
        <h4>Add Review</h4>
        <span class="welcome-note"><em>All reviews and ratings are valid and are from people who have
                used our reservation service</em></span>
        <hr />
        <form id="reviewForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="customerName"><strong>Name:</strong></label>
                <input type="text" class="form-control" id="customerName" name="customerName" autocomplete="off" placeholder="Please enter your name" />
            </div>
            <div class="form-group">
                <label for="customerEmail"><strong>Email:</strong></label>
                <input type="email" class="form-control" id="customerEmail" name="customerEmail" autocomplete="off" placeholder="Please enter your email address" />
            </div>
            <div class="form-group">
                <label for="serviceType"><strong>Select Reservation Type:</strong></label>
                <select class="form-control" id="serviceType" name="serviceType">
                    <option value="">--Click to Select--</option>
                    <option value="RM">Room</option>
                    <option value="EH">Event Hall</option>
                    <option value="CR">Conference Room</option>
                    <option value="PP">Private Pool</option>
                </select>
            </div>
            <div class="form-row">
                <div class="left-container">
                    <label><strong>Review:</strong></label>
                </div>
                <div class="right-container">
                    <div class="star-rating">
                        <i class="star far fa-star" data-rating-value="1"></i>
                        <i class="star far fa-star" data-rating-value="2"></i>
                        <i class="star far fa-star" data-rating-value="3"></i>
                        <i class="star far fa-star" data-rating-value="4"></i>
                        <i class="star far fa-star" data-rating-value="5"></i>

                        <input type="hidden" name="reviewRating" id="reviewRating" value="" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="reviewText" rows="3" autocomplete="off" placeholder="Kindly describe your reservation experience" maxlength="150"></textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
        </form>
    </div>
    <div class="fixed-right right-container">
        <h4>Reservation Ratings & Reviews</h4>
        <div id="reviewReport">
            <!-- Review report will be dynamically generated here -->
            <?php
            if (!empty($validreviews)) {
                foreach ($validreviews as $review) {
            ?>
                    <div class="review-card">
                        <div class="review-header">
                            <div class="review-name"><?php echo $review["name"]; ?></div>
                            <div class="review-rating"><strong>Rating:</strong> <?php echo $review["rating"]; ?>/5</div>
                            <div class="review-date"><strong>Date:</strong> <?php echo isset($review["dateupdated"]) ? $review["dateupdated"] : $review["datecreated"]; ?></div>
                        </div>
                        <div class="review-text"><?php echo $review["reviews"]; ?></div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No reviews found.</p>";
            }
            ?>
        </div>
    </div>

</div>

<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'inc/footer.php';
?>