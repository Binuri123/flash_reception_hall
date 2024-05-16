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
        <link href="<?= SYSTEM_PATH ?>assets/images/flash/logo_with_background.png" rel="icon">
        <link href="<?= SYSTEM_PATH ?>assets/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?= SYSTEM_PATH ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="<?= SYSTEM_PATH ?>/assets/css/login.css" rel="stylesheet">
    </head>
    <?php
    extract($_POST);
//var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'request') {
        $message = array();
        if (empty($email)) {
            $message['error_email'] = "The Email Should not be Empty";
        } elseif (validateEmail($email)) {
            $message['error_email'] = "Invalid Email";
        } else {
            $db = dbConn();
            echo $sql = "SELECT * FROM employee WHERE email='$email'";
            $result = $db->query($sql);
            if ($result->num_rows <= 0) {
                $message['error_email'] = "This email is not registered";
            }
        }

        if (empty($message)) {
            $db = dbConn();
            echo $sql = "SELECT employee_no,first_name,last_name FROM employee WHERE email = '$email'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $employee_no = $row['employee_no'];
            $recepient_name = $row['first_name'] . " " . $row['last_name'];
            $subject = 'Password Reset Request';
            $body = "<p>A new password was requested for Flash Recepton Hall user account.</p>";
            $body .= "<br><br>";
            $body .= "<p>To reset your password click on the confirm link below</p>";
            $body .= "<br><br>";
            $body .= "<a href='http://localhost/flash_reception_hall/system/password_reset/password_reset.php?employee_no=$employee_no'>Confirm Password Reset</a>";
            $alt_body = "If you did not request for it ignore this message";
            send_email($email,$recepient_name,$subject,$body,$alt_body);
            header('location:../login.php');
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
                                    <a href="<?= SYSTEM_PATH ?>login.php" class="text-dark-50">Return to Login</a>
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