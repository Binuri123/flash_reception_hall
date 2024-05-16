<?php
ob_start();
include '../header.php';
?>
<main id="main">
    <section style="margin-top:20px;font-size:13px;">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);
            $first_name = cleanInput($first_name);
            $last_name = cleanInput($last_name);

            $message = array();
            if (empty($first_name)) {
                $message['error_first_name'] = "First Name Should Not Be Blank...";
            }
            if (empty($last_name)) {
                $message['error_last_name'] = "Last Name Should Not Be Blank...";
            }
            if (empty($email)) {
                $message['error_email'] = "Email Should Not Be Blank...";
            }elseif(validateEmail($email)){
                $message['error_email'] = "Invalid Email...";
            }
            if (empty($review)) {
                $message['error_review'] = "Review Should Not Be Blank...";
            }
            if (empty($message)) {
                if (!empty($_FILES['person_image']['name'])) {
                    $person_image = uploadFiles("person_image", $nic, "../assets/img/review/");
                    //var_dump($employee_image);
                    $person_image_name = $person_image['file_name'];
                    if (!empty($person_image['error_message'])) {
                        $message['error_person_image'] = $person_image['error_message'];
                    }
                } else {
                    $person_image_name = 'noImage.png';
                }
            }

            if (empty($message)) {
                $db = dbConn();
                $cDate = date('Y-m-d');
                $sql = "INSERT INTO customer_review(first_name,last_name,email,review,approval_status,add_date,image) "
                        . "VALUES('$first_name','$last_name','$email','$review','Pending','$cDate','$person_image_name')";
                $db->query($sql);

                header('location:' . WEB_PATH . 'index.php?#testimonials');
            }
        }
        ?>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h3 class="h3 mt-1">Share Your Thoughts</h3>
                    <p class="text-danger">* Required</p>
                </div>
                <div class="row" style="font-size:13px;">
                    <div class="col-md-12">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="first_name"><span class="text-danger">*</span> First Name</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <input type="text" name="first_name" value="<?= @$first_name ?>" id="first_name" class="form-control" style="font-size:13px;">
                                            <div class="text-danger"><?= @$message['error_first_name'] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="last_name"><span class="text-danger">*</span> Last Name</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <input type="text" name="last_name" value="<?= @$last_name ?>" id="last_name" class="form-control" style="font-size:13px;">
                                            <div class="text-danger"><?= @$message['error_last_name'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="email"><span class="text-danger">*</span> Email</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <input type="email" name="email" value="<?= @$email ?>" id="email" class="form-control" style="font-size:13px;">
                                            <div class="text-danger"><?= @$message['error_email'] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="person_image">Your Image</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <input type="file" name="person_image" value="<?= @$person_image ?>" id="person_image" class="form-control" style="font-size:13px;">
                                            <div class="text-danger"><?= @$message['error_person_image'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="review"><span class="text-danger">*</span> Review</label>
                                </div>
                                <div class="col-md-10 mb-3">
                                    <textarea type="text" name="review" value="<?= @$review ?>" id="review" class="form-control" style="font-size:13px;"></textarea>
                                    <div class="text-danger"><?= @$message['error_review'] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align:right;">
                                    <button type="submit" class="btn btn-success btn-sm" style="width:100px;font-size:13px;">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </section>
</main>
<?php
include '../footer.php';
ob_end_flush();
?>