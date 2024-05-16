<?php include '../header.php';?>
<?php include '../menu.php';?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Dashboard- Register New Customer</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Customer</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Register</li>
                </ol>
            </nav>
        </div>
      </div>
        
      <?php
        //check the request method
        if($_SERVER['REQUEST_METHOD']== "POST"){
            //extract the array
            extract($_POST);
            // Assign cleaned values to the variables
            $title = cleanInput($title);
            $first_name = cleanInput($first_name);
            $last_name = cleanInput($last_name);
            $street_name = cleanInput($street_name);
            $city = cleanInput($city);
            $district = cleanInput($district);
            $mobile = cleanInput($mobile);
            $land = cleanInput($land);
            $nic = cleanInput($nic);
            $gender = cleanInput($gender);
            
            //Required Validation
            $message = array();
            if(empty($title)){
                $message['error_title'] = "The Title Should Be Selected...";
            }
            if(empty($first_name)){
                $message['error_first_name'] = "The First Name Should Not Be Blank...";
            }
            if(empty($last_name)){
                $message['error_last_name'] = "The Last Name Should Not Be Blank...";
            }
            if(empty($house_no)){
                $message['error_house_no'] = "The House No Should Not Be Blank...";
            }
            if(empty($street_name)){
                $message['error_street_name'] = "The Street Name Should Not Be Blank...";
            }
            if(empty($city)){
                $message['error_city'] = "The City Should Not Be Blank...";
            }
            if(empty($district)){
                $message['error_district'] = "The District Should Not Be Blank...";
            }
            if(empty($mobile)){
                $message['error_mobile'] = "The Mobile Number Should Not Be Blank...";
            }
            if(empty($land)){
                $message['error_land'] = "The Land Number Should Not Be Blank...";
            }
            if(empty($email)){
                $message['error_email'] = "The Email Should Not Be Blank...";
            }
            if(empty($nic)){
                $message['error_nic'] = "The NIC Should Not Be Blank...";
            }
            if(empty($gender)){
                $message['error_gender'] = "The Gender Should Be Selected...";
            }
            if(!isset($acceptance)){
                $message['error_acceptance'] = "You Should Agree to the Terms and Conditions to Register";
            }

            if (empty($message)) {
                $db = dbConn();
                //echo 'Connected..!';
                $userid = $_SESSION['userid'];
                $cDate = date('Y-m-d');
                $sql = "INSERT INTO customers(title_id,first_name,last_name,house_no,street,city, district,mobile,land,email,nic,gender_id,acceptance,add_user,add_date)VALUES('$title','$first_name','$last_name','$house_no','$street_name','$city','$district','$mobile','$land','$email','$nic','$gender','$acceptance','$userid','$cDate')";
                //print_r($sql);
                $db->query($sql);
            }
        } 
      ?>
     
      <h2>Register New Customer</h2>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="customer_reg_no" class="form-label">Customer Registration Number</label>
                <input type="text" class="form-control" id="customer_reg_no" name="customer_reg_no" value="<?= dbConn()->insert_id + 1 ?>" readonly>
<!--            <div class="text-danger"></div>-->
            </div>
            <div class="mb-3 col-md-6">
                <label for="title" class="form-label">Title</label>
                <select class="form-control" id="title" name="title">
                    <option value="" disabled selected>-Select a Title-</option>
                    <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM customer_titles";
                        $result = $db->query($sql);
                        while($row = $result->fetch_assoc()){ 
                    ?>
                        <option value=<?= $row['title_id']; ?> <?php if($row['title_id']== @$title){ ?> selected <?php }?>><?= $row['name']?></option>
                    <?php
                        }
                    ?>
                </select>
                <div class="text-danger"><?= @$message["error_title"]?></div>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= @$first_name ?>">
                <div class="text-danger"><?= @$message["error_first_name"]?></div>
            </div>
            <div class="mb-3 col-md-6">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= @$last_name ?>">
                <div class="text-danger"><?= @$message["error_last_name"]?></div>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-3">
                <label for="house_no" class="form-label">House No</label>
                <input type="text" class="form-control" id="house_no" name="house_no" value="<?= @$house_no ?>">
                <div class="text-danger"><?= @$message["error_house_no"]?></div>
            </div>
            <div class="mb-3 col-md-3">
                <label for="street_name" class="form-label">Street Name</label>
                <input type="text" class="form-control" id="street_name" name="street_name" value="<?= @$street_name ?>">
                <div class="text-danger"><?= @$message["error_street_name"]?></div>
            </div>
            <div class="mb-3 col-md-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="city" name="city" value="<?= @$city ?>">
                <div class="text-danger"><?= @$message["error_city"]?></div>
            </div>
            <div class="mb-3 col-md-3">
                <label for="district" class="form-label">District</label>
                <input type="text" class="form-control" id="district" name="district" value="<?= @$district ?>">
                <div class="text-danger"><?= @$message["error_district"]?></div>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="<?= @$mobile ?>">
                <div class="text-danger"><?= @$message["error_mobile"]?></div>
            </div>
            <div class="mb-3 col-md-4">
                <label for="land" class="form-label">Land Number</label>
                <input type="text" class="form-control" id="land" name="land" value="<?= @$land ?>">
                <div class="text-danger"><?= @$message["error_land"]?></div>
            </div>
            <div class="mb-3 col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= @$email ?>">
                <div class="text-danger"><?= @$message["error_email"]?></div>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="nic" class="form-label">NIC</label>
                <input type="text" class="form-control" id="nic" name="nic" value="<?= @$nic ?>">
                <div class="text-danger"><?= @$message["error_nic"]?></div>
            </div>
            <div class="mb-3 col-md-6">
                <label for="gender" class="form-label">Gender</label>                            
                <select class="form-control" id="gender" name="gender">
                    <option value="" disabled selected>-Select a Gender-</option>
                    <?php
                        $db = dbConn();
                        $sql1 = "SELECT * from gender";
                        $result = $db->query($sql1);
                        while($row = $result->fetch_assoc()){ 
                    ?>
                        <option value=<?= $row['gender_id']; ?> <?php if($row['gender_id']== @$gender){ ?> selected <?php }?>><?= $row['name']?></option>
                    <?php
                        }
                    ?>
                </select>
                <div class="text-danger"><?= @$message["error_gender"]?></div>
            </div>    
        </div>
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= @$username ?>">
                <div class="text-danger"><?= @$message["error_username"]?></div>
            </div>
            <div class="mb-3 col-md-4">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" id="password" name="password" value="<?= @$password ?>">
                <div class="text-danger"><?= @$message["error_password"]?></div>
            </div>
            <div class="mb-3 col-md-4">
                <label for="confirm_pwd" class="form-label">Confirm Password</label>
                <input type="text" class="form-control" id="confirm_pwd" name="confirm_pwd" value="<?= @$confirm_pwd ?>">
                <div class="text-danger"><?= @$message["error_confirm_pwd"]?></div>
            </div>
        </div>
        <div class="row">
            <div class="mb-3">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="status" name="acceptance" value="1" <?php if(isset($acceptance)){ ?>checked <?php } ?>>
                    <label class="form-check-label" for="acceptance">I Agree to the Terms and Conditions</label>
                </div>
                <div class="text-danger"><?= @$message["error_acceptance"]?></div>
            </div>
        </div>
        <div class="row">
            <div class="mb-3" style="text-align:right">
                <button type="submit" class="btn btn-success" style="width:200px">Add</button>
                <button type="reset" class="btn btn-warning" style="width:200px">Cancel</button>
            </div>
        </div>
      </form>
    </main>

 <?php include '../footer.php';?>