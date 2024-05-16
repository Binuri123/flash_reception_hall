<?php
session_start();
include '../function.php';
include '../config.php';
include '../assets/phpmail/mail.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET)) {
    extract($_GET);
    //var_dump($_GET);
    $hall_id = $_GET['hall_id'];
    $check_availability_id = $_GET['check_availability_id'];
}

extract($_POST);
//var_dump($_POST);
//echo 'outside';
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'login') {
//    echo 'inside';
    //Data Cleaning
    //Clean the username inputted and assign it to the UserName Variable
    $username = cleanInput($username);

    $message = array();
    if (empty($username)) {
        $message['error_username'] = "The Username Should not be Empty";
    }
    if (empty($password)) {
        $message['error_password'] = "The Password Should not be Empty";
    }
    if (empty($message)) {
        $password = sha1($password);
        $sql = "SELECT u.user_id,c.customer_id,t.title_name,c.first_name,c.last_name,ur.role_name FROM user u "
        . "LEFT JOIN customer c ON c.user_id = u.user_id "
        . "LEFT JOIN user_role ur ON ur.user_role_id=u.user_role_id "
        . "LEFT JOIN customer_titles t ON t.title_id=c.title_id "
        . "WHERE u.user_role_id='7' AND u.username = '$username' AND u.password = '$password'";
        $db = dbConn();
        $result = $db->query($sql);

        if ($result->num_rows <= 0) {
            $message['error_login'] = "Invalid Username or Password";
        } else {
            $row = $result->fetch_assoc();
            $_SESSION['userid'] = $row['user_id'];
            $_SESSION['customer_id'] = $row['customer_id'];
            $_SESSION['title'] = $row['title_name'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['user_role'] = $row['role_name'];

            if (!empty($check_availability_id)) {
                header("Location:../reservation/event_details.php?check_availability_id=$check_availability_id");
            } else {
                header("Location:dashboard.php");
            }
        }
    }
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login-Flash Reception Hall</title>
        <link href="<?= WEB_PATH ?>assets/img/flash/logo_with_background.png" rel="icon">
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?= WEB_PATH ?>assets/dashboard_assets/css/login.css" rel="stylesheet">
    </head>
    <body class="text-center" style="background-color: rgba(0, 0, 0, 0.8);">
        <section class="vh-100 gradient-custom">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-4 h-90 mt-3">
                        <div class="card bg-white text-dark h-90" style="border-radius:10px;">
                            <div class="card-body text-center">
                                <div>
                                    <?php
                                    //var_dump($_GET);
                                    ?>
                                    <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                    <p class="text-dark-50 mb-3">Please Enter Your Username and Password!</p>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                        <div class="text-danger"><?= @$message['error_username'] ?></div>
                                        <div class="text-danger"><?= @$message['error_password'] ?></div>
                                        <div class="text-danger"><?= @$message['error_login'] ?></div>
                                        <div class="form-outline form-dark mb-3" style="text-align:left">
                                            <label class="form-label" for="username"><strong>Username</strong></label>
                                            <input type="text" id="email" name="username" class="form-control" autocomplete="off"/>
                                        </div>
                                        <div class="form-outline form-dark mb-3" style="text-align:left">
                                            <label class="form-label" for="password"><strong>Password</strong></label>
                                            <input type="password" id="password" name="password" class="form-control" autocomplete="off"/>
                                        </div>
                                        <p class="small mb-3"><a class="text-dark-50" href="<?= WEB_PATH ?>password_reset/password_reset_request.php">Forgot password?</a></p>
                                        <input type="hidden" name="check_availability_id" value="<?= @$check_availability_id ?>">
                                        <button class="btn btn-outline-dark btn-sm px-4 py-2 mb-3" type="submit" name="action" value="login">Login</button>
                                    </form> 
                                </div>
                                <div>
                                    <p class="mb-3">Don't have an account? 
                                        <?php
                                        if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET)) {
                                            extract($_GET);
                                            //var_dump($_GET);
                                            ?>
                                            <a href="<?= WEB_PATH ?>customer/register_customer.php?check_availability_id=<?= @$check_availability_id ?>" class="text-dark-50">Register</a>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="<?= WEB_PATH ?>customer/register_customer.php" class="text-dark-50">Register</a>
                                            <?php
                                        }
                                        ?>
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