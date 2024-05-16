<?php
session_start();
include '../../system/function.php';
include '../config.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reset Password-Flash Reception Hall</title>
        <link href="../../system/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>customer/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="<?= WEB_PATH ?>/assets/dashboard_assets/css/login.css" rel="stylesheet">
        <script src="<?= WEB_PATH ?>assets/js/sweetalert2.all.js" type="text/javascript"></script>
    </head>
<?php
extract($_POST);
//var_dump($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $message = array();
    if (empty($email)) {
        $message['error_email'] = "The Email Should not be Empty";
    }else{
        $db = dbConn();
        $sql = "SELECT * FROM customers WHERE email='$email'";
        $result = $db->query($sql);
        if($result->num_rows <= 0){
            $message['error_email'] = "This email is not registered";
        }
    }
    if (empty($password)) {
        $message['error_password'] = "The Password Should not be Empty";
    } else {
        $message['error_password'] = validatePassword($password);
        $db = dbConn();
        $sql = "SELECT password FROM users where user_id = (SELECT user_id FROM customers WHERE email='$email')";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $old_password = $row['password'];
            $password = sha1($password);
            $confirm_password = sha1($confirm_password);
            if ($old_password == $password) {
                $message['error_password'] = "New password cannot be the Old password";
            }
        }
    }
    if (empty($confirm_password)) {
        $message['error_confirm_password'] = "The Confirm Password Should not be Empty";
    }
    if ($password != $confirm_password) {
        $message['error_confirm_password'] = "Passwords doesn't match";
    }
    
    if($message['error_password'] == null){
        $message = '';
    }
    
    if (empty($message)) {
        $password = sha1($password);
        $sql = "UPDATE users SET password ='$password' WHERE user_id = (SELECT user_id FROM customers WHERE email = '$email')";
        $db->query($sql);
        //header("Location:reset_success.php");
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
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                        <div class="form-outline form-dark mb-3" style="text-align:left">
                                            <label class="form-label" for="email"><strong><span class="text-danger">*</span>Registered Email</strong></label>
                                            <input type="text" id="email" name="email" class="form-control" onchange="form.submit()" value="<?= @$email ?>">
                                            <div class="text-danger"><?= @$message['error_email'] ?></div>
                                        </div>
                                        <div class="form-outline form-dark mb-3" style="text-align:left">
                                            <label class="form-label" for="password"><strong><span class="text-danger">*</span>New Password</strong></label>
                                            <input type="password" id="password" name="password" class="form-control" value="<?= @$password ?>">
                                            <div class="text-danger"><?= @$message['error_password'] ?></div>
                                        </div>
                                        <div class="form-outline form-dark mb-3" style="text-align:left">
                                            <label class="form-label" for="confirm_password"><strong><span class="text-danger">*</span>Confirm Password</strong></label>
                                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" value="<?= @$confirm_password ?>">
                                            <div class="text-danger"><?= @$message['error_confirm_password'] ?></div>
                                        </div>
                                        <button class="btn btn-outline-dark btn-sm px-4 py-2 mb-3" type="submit" name="action" value="save">Reset</button>
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