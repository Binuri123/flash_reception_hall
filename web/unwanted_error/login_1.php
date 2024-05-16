<?php
session_start();
include '../system/function.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login-Flash Reception Hall</title>
        <link href="../system/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/login_1.css" rel="stylesheet">
    </head>
    <body class="text-center" style="background-color: rgba(0, 0, 0, 0.8);">
        <main class="form-signin bg-warning w-100 m-auto border border-2 border-dark">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

                extract($_POST);

                //Data Cleaning
                //Clean the username inputted and assign it to the UserName Variable
                $UserName = cleanInput($UserName);

                $message = array();

                if (empty($UserName)) {
                    $message['error_username'] = "The Username Should not be Empty";
                }

                if (empty($password)) {
                    $message['error_password'] = "The Password Should not be Empty";
                }

                if (empty($message)) {
                    $password = sha1($password);
                    $sql = "SELECT * FROM users u LEFT JOIN user_role r ON r.role_id = u.role_id LEFT JOIN customers c ON c.user_id = u.user_id LEFT JOIN customer_titles t ON t.title_id=c.title_id WHERE u.username = '$UserName' AND u.password = '$password'";
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


                        header("Location:index.php");
                    }
                }
            }
            ?>
            <form form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="bg-white">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <img class="mb-4" src="assets/img/flash/logo.png" alt="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h1 class="h3 mb-3 fw-normal text-white">Please sign in</h1>
                    </div>
                </div>
                <div class="text-danger mb-3"><?= @$message['error_username']; ?></div>
                <div class="text-danger mb-3"><?= @$message['error_password']; ?></div>
                <div class="text-danger mb-3"><?= @$message['error_login']; ?></div>
                <div class="row">
                    <div class="mb-3">
                        <label for="UserName">Username</label>
                        <input type="text" class="form-control" id="UserName" name="UserName" placeholder="Enter Username">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                    </div>
                </div>
                <div class="row">
                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <p class="mt-5 mb-3 text-muted">Not a member?<a href="register.php">Register</a></p>
                    </div>
                </div>
            </form>
        </main>    
    </body>
</html>
