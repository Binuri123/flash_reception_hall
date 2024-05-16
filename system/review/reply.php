<?php
ob_start();
include '../header.php';
include '../menu.php';
include '../assets/phpmail/mail.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>review/review.php">Reviews</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reply</li>
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
        $approval = $row['approval_status'];
        $approval_date = $row['approved_date'];
        $approval_user = $row['approved_user'];
    }

    extract($_POST);
    //var_dump($_POST);

    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'reply') {
        $message = array();

        if (empty($reply)) {
            $message['error_reply'] = "Reply Should Not Be Blank...";
        }

        if (empty($message)) {
            $db = dbConn();
            $cDate = date('Y-m-d');
            $user_id = $_SESSION['userid'];
            $sql = "UPDATE customer_review SET reply='$reply',reply_status='Replied',replied_date='$cDate' WHERE review_id='$review_id'";
            $db->query($sql);

            $to = $reviewer_email;
            $recepient_name = $reviewer_name;
            $subject = 'Flash Reception Hall - Thank You For Your Review';
            $body = "<p>".$reply."</p>";
            $body .= "<p>Thank You,</p><br><p>Flash Reception Hall.</p>";
            $alt_body = "<p>Thank You For Your Review</p>";
            send_email($to, $recepient_name, $subject, $body, $alt_body);

            header('location:' . SYSTEM_PATH . 'review/review.php');
        }
    }
    ?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card bg-light">
                <div class="card-header">
                    <h4>Reply</h4>
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
                                <label class="form-label">Approval Status</label>
                            </div>
                            <div class="col-md-8">
                                <div><?= @$approval ?></div>
                                <input type="hidden" name="approval" value="<?= @$approval ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Approval Date</label>
                            </div>
                            <div class="col-md-8">
                                <div><?= @$approval_date ?></div>
                                <input type="hidden" name="approval_date" value="<?= @$approval_date ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Approval Done By</label>
                            </div>
                            <div class="col-md-8">
                                <?php
                                $db = dbConn();
                                $sql_approve_user = "SELECT role_name FROM user_role WHERE user_role_id = (SELECT user_role_id FROM user WHERE user_id='$approval_user')";
                                $result_approve_user = $db->query($sql_approve_user);
                                $row_approve_user = $result_approve_user->fetch_assoc();
                                $approved_by = $row_approve_user['role_name'];
                                ?>
                                <div><?= @$approved_by ?></div>
                                <input type="hidden" name="approval_user" value="<?= @$approval_user ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Reply</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="reply" value='<?= @$reply ?>' id="reply" class="form-control" style="font-size:13px;"></textarea>
                                <div class="text-danger"><?= @$message['error_reply'] ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12" style="text-align:right;">
                                <input type="hidden" name="review_id" value="<?= @$review_id ?>">
                                <button type="submit" class="btn btn-sm btn-success" name="action" value="reply">Send</button>
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
