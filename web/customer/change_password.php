<?php
ob_start();
include 'header.php';
include 'sidebar.php';
?>
<main id="main">
    <section>
        <div class="pagetitle">
            <h1>Change Password</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Change Password</li>
                </ol>
            </nav>
        </div>
    </section>
    <?php
    extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'change_password') {
        $message = array();
        if (empty($current_password)) {
            $message["error_current_password"] = "Current Password Should not be Blank...";
        }

        if (empty($new_password)) {
            $message["error_new_password"] = "New Password Should not be Blank...";
        } else {
            $uppercase_letter = preg_match('@[A-Z]@', $new_password);
            $lowercase_letter = preg_match('@[a-z]@', $new_password);
            $numeric_value = preg_match('@[0-9]@', $new_password);
            $special_characters = preg_match('@[^\w]@', $new_password);

            if (!$uppercase_letter || !$lowercase_letter || !$numeric_value || !$special_characters) {
                $message['error_new_password'] = "Password should include at least one capital letter, a simple letter, a number and a special character";
            } else if (strlen($new_password) < 8) {
                $message['error_new_password'] = "Password should be at least 8 characters";
            } else if (strpos($new_password, " ")) {
                $message['error_new_password'] = "Password Should not Contain Spaces";
            }
        }

        if (empty($confirm_password)) {
            $message["error_confirm_password"] = "Confirm Password Should not be Blank...";
        }

        if (!empty($current_password)) {
            $db = dbConn();
            $sql_old_pwd = "SELECT password FROM user WHERE user_id='" . $_SESSION['userid'] . "'";
            $result_old_pwd = $db->query($sql_old_pwd);
            $row_old_pwd = $result_old_pwd->fetch_assoc();
            $old_pwd = $row_old_pwd['password'];
            if (sha1($current_password) != $old_pwd) {
                $message["error_current_password"] = "Entered Current Password is Incorrect...";
            }
        }

        if (!empty($new_password) && !empty($confirm_password)) {
            if ($new_password != $confirm_password) {
                $message["error_confirm_password"] = "Confirm Password Should be Same New Password...";
            }
        }
        
        if(empty($message)){
            $db = dbConn();
            $new_password = sha1($new_password);
            $sql = "UPDATE user SET password='$new_password' WHERE user_id='".$_SESSION['userid']."'";
            $db->query($sql);
            
            header('location:'.WEB_PATH.'customer/dashboard.php');
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-3"></div>
        <div class="mb-3 col-md-6">
            <div class="card bg-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="h4">Change Password</h1>
                        </div>
                        <div class="col-md-6" style="text-align:right">
                            <p class="text-danger text-right" style="font-size:13px;">* Required</p>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="font-size:13px;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                        <div class="row mt-3">
                            <div class="mb-3 col-md-4">
                                <label for="current_password" class="form-label"><span class="text-danger">*</span> Current Password</label>
                            </div>
                            <div class="mb-3 col-md-8">
                                <input class="form-control" type="password" name="current_password" id="current_password" value="<?= @$current_password ?>" style="font-size:13px;">
                                <div class="text-danger"><?= @$message["error_current_password"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="new_password" class="form-label"><span class="text-danger">*</span>New Password</label>
                            </div>
                            <div class="mb-3 col-md-8">
                                <input type="password" class="form-control" id="new_password" name="new_password" value="<?= @$new_password ?>" style="font-size:13px;">
                                <div class="text-danger"><?= @$message["error_new_password"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="confirm_password" class="form-label"><span class="text-danger">*</span>Confirm Password</label>
                            </div>
                            <div class="mb-3 col-md-8">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="<?= @$confirm_password ?>" style="font-size:13px;">
                                <div class="text-danger"><?= @$message["error_confirm_password"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div style="text-align:right">
                                <button type="submit" name="action" value="change_password" class="btn btn-success btn-sm" style="font-size:13px;width:150px;">Change Pasword</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</main>
<?php
include 'footer.php';
ob_end_flush();
?>