<?php
    session_start();
    include 'function.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login-Flash Reception Hall</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/login.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <main class="form-signin bg-success w-100 m-auto border border-2 border-dark">
        <?php
            if($_SERVER['REQUEST_METHOD']== "POST"){
                
                extract($_POST);
                
                //Data Cleaning
                //Clean the username inputted and assign it to the UserName Variable
                $UserName = cleanInput($UserName);
                
                $message = array();
                
                if(empty($UserName)){
                    $message['error_username'] = "The Username Should not be Empty";
                }
                
                if(empty($Password)){
                    $message['error_password'] = "The Password Should not be Empty";
                }
                
                if(empty($message)){
                    $Password = sha1($Password);
                    $sql = "SELECT * FROM users u LEFT JOIN user_role r ON r.role_id = u.role_id LEFT JOIN customer c ON c.user_id = u.user_id WHERE u.username = '$UserName' AND u.password = '$Password'";
                    $db = dbConn();
                    $result = $db->query($sql);
                    
                    if($result->num_rows<=0){
                        $message['error_login'] = "Invalid Username or Password";
                    }else{
                        $row = $result->fetch_assoc();
                        $_SESSION['userid'] = $row['user_id'];
                        $_SESSION['customer_id'] = $row['customer_id'];
                        $_SESSION['title'] = $row['title'];
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        $_SESSION['user_role'] = $row['role_name'];
                        
                        
                        header("Location:index.php");
                    }
                }
            }
        ?>
        <form form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <img class="mb-4" src="assets/images/logo.png" alt="">
            
            <h1 class="h3 mb-3 fw-normal text-white">Please sign in</h1>
            
            <div class="text-danger"><?= @$message['error_username'];?></div>
            <div class="text-danger"><?= @$message['error_password'];?></div>
            <div class="text-danger"><?= @$message['error_login'];?></div>
            <div class="form-floating">
                <input type="text" class="form-control" id="UserName" name="UserName" placeholder="Enter Username">
                <label for="floatingInput">Username</label>
            </div>
            
            <div class="form-floating">
                <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter Password">
                <label for="floatingPassword">Password</label>
            </div>
            
            <div class="checkbox mb-3">
              <label>
                <input type="checkbox" value="remember-me"> Remember me
              </label>
            </div>
            
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p>
      </form>
    </main>    
  </body>
</html>
