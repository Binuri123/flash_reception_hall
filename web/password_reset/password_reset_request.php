<?php
ob_start();
session_start();
include '../function.php';
include '../config.php';
include '../assets/phpmail/mail.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reset Password-Flash Reception Hall</title>
        <link href="<?= WEB_PATH ?>assets/img/flash/logo_with_background.png" rel="icon">
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?= WEB_PATH ?>customer/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>/assets/dashboard_assets/css/login.css" rel="stylesheet">
        <script src="<?= WEB_PATH ?>assets/js/sweetalert2.all.js" type="text/javascript"></script>
    </head>
    <?php
    extract($_POST);
//var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'request') {
        $message = array();
        if (empty($email)) {
            $message['error_email'] = "The Email Should not be Empty";
        } elseif (validateEmail($email) == FALSE) {
            $message['error_email'] = "Invalid Email";
        } else {
            $db = dbConn();
            echo $sql = "SELECT * FROM customer WHERE email='$email'";
            $result = $db->query($sql);
            if ($result->num_rows <= 0) {
                $message['error_email'] = "This email is not registered";
            }
        }

        if (empty($message)) {
            $db = dbConn();
            echo $sql = "SELECT reg_no,first_name,last_name FROM customer WHERE email = '$email'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $reg_no = $row['reg_no'];
            $recepient_name = $row['first_name'] . " " . $row['last_name'];
            $subject = 'Password Reset Request';
            $body = "<p>A new password was requested for Flash Recepton Hall customer account.</p>";
            $body .= "<br><br>";
            $body .= "<p>To reset your password click on the confirm link below</p>";
            $body .= "<br><br>";
            $body .= "<a href='http://localhost/flash_reception_hall/web/password_reset/password_reset.php?reg_no=$reg_no'>Confirm Password Reset</a>";
            $alt_body = "If you did not request for it ignore this message";
            send_email($email, $recepient_name, $subject, $body, $alt_body);
            header('location:../customer/login.php');
        }
    }
    ?>
    <body class="text-center" style="background-color: rgba(0, 0, 0, 0.8);">
        <section class="vh-100 gradient-custom">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-4 h-90 mt-3">
                        <div class="card bg-white text-dark h-90" style="border-radius:10px;">
                            <div class="card-body text-center">
                                <div>
                                    <h2 class="fw-bold mb-2 mb-3"><i class="bi bi-lock-fill"></i> Reset Password</h2>
                                    <p style="text-align:justify">
                                        <strong><i>Enter the e-mail address associated with your account. Click submit to have a password reset link e-mailed to you.</i></strong>
                                    </p>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                        <div class="form-outline form-dark mb-3" style="text-align:left">
                                            <label class="form-label" for="email"><strong><span class="text-danger">*</span>Your Email Address</strong></label>
                                            <input type="text" id="email" name="email" class="form-control" onchange="form.submit()" value="<?= @$email ?>">
                                            <div class="text-danger"><?= @$message['error_email'] ?></div>
                                        </div>
                                        <button class="btn btn-outline-dark btn-sm px-4 py-2 mb-3" type="submit" name="action" value="request">Continue</button>
                                    </form> 
                                </div>
                                <div>
                                    <a href="<?= WEB_PATH ?>customer/login.php" class="text-dark-50">Return to Login</a>
                                </div>
                                <div>
                                    <p class="mb-3">Don't have an account? 
                                        <a href="<?= WEB_PATH ?>customer/register_customer.php" class="text-dark-50">Register</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
<?php
ob_end_flush();
?>