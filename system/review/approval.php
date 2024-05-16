<?php
ob_start();
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>review/review.php">Reviews</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>review/received.php">Received Reviews</a></li>
                <li class="breadcrumb-item active" aria-current="page">Approval</li>
            </ol>
        </nav>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
        $db = dbConn();
        $sql = "SELECT * FROM customer_review WHERE review_id='$review_id'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $reviewer_name = $row['first_name'] . ' ' . $row['last_name'];
        $reviewer_email = $row['email'];
        $review = $row['review'];
        $added_date = $row['add_date'];
    }

    extract($_POST);
    //var_dump($_POST);

    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'approval') {
        $message = array();

        if (empty($approval)) {
            $message['error_approval'] = "Approval Status Should Be Selected...";
        }

        if (empty($message)) {
            $db = dbConn();
            $cDate = date('Y-m-d');
            $user_id = $_SESSION['userid'];
            $sql = "UPDATE customer_review SET approval_status='$approval',approved_date='$cDate',approved_user='$user_id' WHERE review_id='$review_id'";
            $db->query($sql);

            header('location:' . SYSTEM_PATH . 'review/review.php');
        }
    }
    ?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card bg-light">
                <div class="card-header">
                    <h4>Approval</h4>
                </div>
                <div class="card-body" style="font-size:13px;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Reviewer Name</label>
                            </div>
                            <div class="col-md-8">
                                <div><?= @$reviewer_name ?></div>
                                <input type="hidden" name="reviewer_name" value="<?= @$reviewer_name ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Reviewer Email</label>
                            </div>
                            <div class="col-md-8">
                                <div><?= @$reviewer_email ?></div>
                                <input type="hidden" name="reviewer_email" value="<?= @$reviewer_email ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Review</label>
                            </div>
                            <div class="col-md-8">
                                <div><?= @$review ?></div>
                                <input type="hidden" name="review" value="<?= @$review ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Added Date</label>
                            </div>
                            <div class="col-md-8">
                                <div><?= @$added_date ?></div>
                                <input type="hidden" name="added_date" value="<?= @$added_date ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Approval</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="approval" id="approved" value="Approved" <?php if (isset($approval) && @$approval == 'Approved') { ?> checked <?php } ?> style="font-size:13px;">
                                    <label class="form-check-label" for="approved">Approved</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="approval" id="unapproved" value="Unapproved" <?php if (isset($approval) && @$approval == 'Unapproved') { ?> checked <?php } ?> style="font-size:13px;">
                                    <label class="form-check-label" for="unapproved">Not Approved</label>
                                </div>
                                <div class="text-danger"><?= @$message['error_approval'] ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12" style="text-align:right;">
                                <input type="hidden" name="review_id" value="<?=@$review_id?>">
                                <button type="submit" class="btn btn-sm btn-success" name="action" value="approval">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</main>
<?php 
include '../footer.php';
ob_end_flush();
?>
