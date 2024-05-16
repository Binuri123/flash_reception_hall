<?php
session_start();
include '../function.php';
include '../config.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reset Password-Flash Reception Hall</title>
        <link href="<?= SYSTEM_PATH ?>assets/images/flash/logo_with_background.png" rel="icon">
        <link href="<?= SYSTEM_PATH ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?= SYSTEM_PATH ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="<?= SYSTEM_PATH ?>/assets/css/login.css" rel="stylesheet">
    </head>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
        $employee_no = $_GET['employee_no'];
    }
    extract($_POST);
//var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'reset_password') {
        $message = array();
        if (empty($password)) {
            $message['error_password'] = "The Password Should not be Empty";
        }

        if (!empty($password)) {
            $uppercase_letter = preg_match('@[A-Z]@', $password);
            $lowercase_letter = preg_match('@[a-z]@', $password);
            $numeric_value = preg_match('@[0-9]@', $password);
            $special_characters = preg_match('@[^\w]@', $password);

            if (!$uppercase_letter || !$lowercase_letter || !$numeric_value || !$special_characters) {
                $message['error_password'] = "Password should include at least one capital letter, a simple letter, a number and a special character";
            } else if (strlen($password) < 8) {
                $message['error_password'] = "Password should be at least 8 characters";
            } else if (strpos($password, " ")) {
                $message['error_password'] = "Password Should not Contain Spaces";
            }
        }

        if (empty($message['error_password'])) {
            $db = dbConn();
            echo $sql = "SELECT password FROM users where user_id=(SELECT user_id FROM employee WHERE customer_id='$customer_id')";
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
        var_dump($message);
        if (empty($message)) {
            //$password = sha1($password);
            echo $sql = "UPDATE users SET password ='$password' WHERE user_id = (SELECT user_id FROM employee WHERE employee_no='$employee_no')";
            $db->query($sql);
            header("Location:reset_success.php");
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
                                        <h3 class="fw-bold mb-2 mb-3"><i class="bi bi-lock-fill"></i> Reset Your Password</h3>
                                        <p style="text-align:justify">
                                            <strong><i>Enter the new password you wish to use.</i></strong>
                                        </p>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
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
                                            <input type="hidden" name="employee_no" value="<?= @$employee_no ?>">
                                            <button class="btn btn-outline-dark btn-sm px-4 py-2 mb-3" type="submit" name="action" value="reset_password">Reset</button>
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