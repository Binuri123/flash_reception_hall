<?php
session_start();
include 'config.php';
include 'function.php';

//Check the Request Method
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    extract($_POST);
    //var_dump($_POST);
    //Data Cleaning
    //Clean the username inputted and assign it to the UserName Variable
    $username = cleanInput($username);

    $message = array();
    //Required Field Validation
    if (empty($username)) {
        $message['error_username'] = "The Username Should not be Empty";
    }
    if (empty($password)) {
        $message['error_password'] = "The Password Should not be Empty";
    }
    //Authenticating the Credentials
    if (empty($message)) {
        //Convert password into sha1 encryption because the database containing the encrypted password
        $password = sha1($password);
        //Query for retreiving data record with given credentials 
        $sql = "SELECT * FROM user u"
                . " LEFT JOIN user_role r ON r.user_role_id = u.user_role_id"
                . " WHERE u.username = '$username' AND u.password = '$password'";
        //creating the database connectivity
        $db = dbConn();
        //Executing the query
        $result = $db->query($sql);
        //Check for having matching records
        if ($result->num_rows <= 0) {
            //Displaying the error message if not any record matched
            $message['error_login'] = "Invalid Username or Password";
        } else {
            $row = $result->fetch_assoc();
            //Storing the relevant data into the session
            if ($row['user_role_id'] != '8' && $row['user_status'] == 'Active') {
                $_SESSION['userid'] = $row['user_id'];
                $_SESSION['user_role'] = $row['role_name'];
                $_SESSION['user_role_id'] = $row['user_role_id'];
                
                if ($row['user_role_id'] != '1') {
                    $sql_emp = "SELECT employee_id,title,first_name,last_name FROM employee WHERE user_id =" . $row['user_id'];
                    $result_emp = $db->query($sql_emp);
                    $row_emp = $result_emp->fetch_assoc();
                    $_SESSION['employee_id'] = $row['employee_id'];
                    $_SESSION['title'] = $row['title'];
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                }
            }else{
                $message['error_login'] = "Your User Account is not Activated";
            }

            //Redireting to the Dashboard of Authenticated User
            header("Location:index.php");
        }
    }
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login-Flash Reception Hall</title>
        <link href="<?= SYSTEM_PATH ?>assets/images/flash/logo_with_background.png" rel="icon">
        <link href="<?= SYSTEM_PATH ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= SYSTEM_PATH ?>assets/css/login.css" rel="stylesheet">
    </head>
    <body class="text-center" style="background-color: rgba(0, 0, 0, 0.8);">
        <section class="vh-100 gradient-custom">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-4 h-90 mt-3">
                        <div class="card bg-white text-dark h-90" style="border-radius:10px;">
                            <div class="card-body text-center">
                                <div>
                                    <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                    <p class="text-dark-50 mb-3">Please Enter Your Username and Password!</p>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                        <div class="text-danger"><?= @$message['error_username'] ?></div>
                                        <div class="text-danger"><?= @$message['error_password'] ?></div>
                                        <div class="text-danger"><?= @$message['error_login'] ?></div>
                                        <div class="form-outline form-dark mb-3" style="text-align:left">
                                            <label class="form-label" for="username" style="font-size:13px;"><strong>Username</strong></label>
                                            <input type="text" id="email" name="username" class="form-control" style="font-size:13px;"/>
                                        </div>
                                        <div class="form-outline form-dark mb-3" style="text-align:left">
                                            <label class="form-label" for="password" style="font-size:13px;"><strong>Password</strong></label>
                                            <input type="password" id="password" name="password" class="form-control" style="font-size:13px;"/>
                                        </div>
                                        <p class="small mb-3"><a class="text-dark-50" href="<?= SYSTEM_PATH ?>password_reset/password_reset_request.php">Forgot password?</a></p>
                                        <button class="btn btn-outline-dark btn-sm px-4 py-2 mb-3" type="submit">Login</button>
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>