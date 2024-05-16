<?php 
session_start();
include '../system/function.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login-Nectar Mount Resort</title>
<link href="../system/assets/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="../system/assets/css/login_old.css" rel="stylesheet">
  </head>
  <body class="text-center">
    
<main class="form-signin bg-transparent w-100 m-auto border border-2 border-dark">
  
    <?php 
    if($_SERVER['REQUEST_METHOD']=="POST"){
       extract($_POST);
        
       $UserName= cleanInput($UserName);
       
       $message= array();
       
       if(empty($UserName)){
           $message['error_username']="User Name should not be blank";
       }
       
       if(empty($Password)){
           $message['error_password']="The Password should not be blank";
       }
       
       if(empty($message)){
           $Password= sha1($Password);
          $sql="SELECT * FROM tbl_users u LEFT JOIN tbl_user_roles r ON r.RoleId=u.RoleId LEFT JOIN tbl_customers c ON c.UserId=u.UserId LEFT JOIN tbl_customer_title t ON t.TitleId=c.TitleId WHERE u.UserName='$UserName' AND u.Password='$Password'";
          print_r($sql);
          $db= dbConn();
          $result=$db->query($sql);
          if($result->num_rows<=0){
              $message['error_login']="Invalid User Name or Password";
          } else {
             $row = $result->fetch_assoc() ;
              $_SESSION['userid'] = $row['UserId'];
              $_SESSION['title'] = $row['TitleName'];
              $_SESSION['firstname'] = $row['FirstName'];
              $_SESSION['lastname'] = $row['LastName'];
              $_SESSION['userrole'] = $row['RoleName'];
              header("Location:index.php");
          }
          
       }
       
       
    }
    
    
    ?>
    
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"> 
    <img class="mb-4" src="../system/assets/images/logo1.png" alt="">
    <h1 class="h3 mb-3 fw-normal text-dark">Please sign in</h1>

    <div class="text-danger">
    
         <?= @$message['error_username'] ?>  
    </div>
    
     <div class="text-danger">
    
         <?= @$message['error_password'] ?>  
    </div>
    
    <div class="text-danger">
    
         <?= @$message['error_login'] ?>  
    </div>
    
    <div class="form-floating">
      <input type="text" class="form-control" id="UserName" name="UserName" placeholder="Enter User Name">
      <label for="UserName">User Name</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter Password">
      <label for="Password">Password</label>
    </div>

    
    <button class="w-100 btn btn-lg btn-secondary" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted"></p>
  </form>
</main>


    
  </body>
</html>
