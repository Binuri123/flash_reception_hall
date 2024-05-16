<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main id="main" class="col-md-10 ms-sm-auto col-lg-11 px-md-4">
    <section>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Register as Customer  </h1>
            <!--        <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-success"><span data-feather="plus-circle" class="align-text-bottom"></span>New Employee</button>
                            <button type="button" class="btn btn-sm btn-outline-warning"><span data-feather="edit" class="align-text-bottom"></span>Update Employee</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle">
                            <span data-feather="user" class="align-text-bottom"></span>
                            Search Employee
                        </button>
                    </div>-->
        </div>

        <?php
//     
        // ignore spaces (trim)     
        //  $Pname=trim($Pname);  
        // remove backslash \
        //  $Pname=stripcslashes($Pname);   
        // 
        //  $Pname= htmlspecialchars($Pname); 
        //  echo $Pname; 
        //  echo $pQty;
        //  echo $Pprice;
        // 1st step- check the request method  
        if ($_SERVER['REQUEST_METHOD'] == "POST") {


            // 2nd step- extact the form field 
            // convert array keys to the seperate variable with the value(extract)
            extract($_POST);

            // 3rd step- clean input
            $title = cleanInput($title);
            $fname = cleanInput($fname);
            $lname = cleanInput($lname);
            $nic = cleanInput($nic);
            $gender = cleanInput($gender);
            $district = cleanInput($district);
            $houseno = cleanInput($houseno);
            $streetname = cleanInput($streetname);
            $area = cleanInput($area);
            $contact = cleanInput($contact);
            $contact2 = cleanInput($contact2);
            $email = cleanInput($email);
            

            // Required Validation
            $message = array();

            if (empty($title)) {
                $message['error_title'] = "Title should be selected..!";
            }


            if (empty($fname)) {
                $message['error_fname'] = "First Name should not be blank..!";
            }

            if (empty($lname)) {
                $message['error_lname'] = "Last Name should not be blank..!";
            }

            if (empty($nic)) {
                $message['error_nic'] = "NIC should not be blank..!";
            } elseif (nicValidation($nic)) {
                $message['error_nic'] = "Invalid Nic Format";
            } else {
                $db = dbConn();
                $sql = "SELECT * FROM tbl_customers WHERE NIC='$nic'";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_nic'] = "This Nic is Already Exist";
                }
            }

            if (empty($gender)) {
                $message['error_gender'] = "Should be select Gender..!";
            }

            if (empty($district)) {
                $message['error_district'] = "Should be select district..!";
            }



            if (empty($houseno)) {
                $message['error_houseno'] = "House No should not be blank..!";
            }


            if (empty($streetname)) {
                $message['error_streetname'] = "Street Name should not be blank..!";
            }

            if (empty($area)) {
                $message['error_area'] = "Area should not be blank..!";
            }

            if (empty($contact)) {
                $message['error_contact'] = "Contact No should not be blank..!";
            } elseif (contactNoValidation($contact)) {
                $message['error_contact'] = "Invalid Contact Number";
            }

            if (!empty($contact2) && contactNoValidation($contact2)) {
                $message['error_contact2'] = "Invalid Contact Number";
            }


            if (empty($email)) {
                $message['error_email'] = "Email should not be blank..!";
            } elseif (emailValidation($email)) {
                $message['error_email'] = "Invalid Email Address";
            } else {
                $db = dbConn();
                $sql = "SELECT * FROM tbl_customers WHERE Email='$email'";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_email'] = "This Email Address is Already Exist";
                }
            }


            if (empty($username)) {
                $message['error_username'] = "User Name should not be blank..!";
            }

            if (empty($pwd)) {
                $message['error_pwd'] = "Password should not be blank..!";
            } elseif (strlen($pwd) < 8) {
                $message['error_pwd'] = "Password must be at least 8 characters long..!";
            } elseif (!preg_match('/[A-Z]/', $pwd) || !preg_match('/[a-z]/', $pwd) || !preg_match('/[0-9]/', $pwd) || !preg_match('/[^A-Za-z0-9]/', $pwd)) {
                $message['error_pwd'] = "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character..!";
            } elseif ($pwd == $username) {
                $message['error_pwd'] = "Password must not be the same as the username..!";
            } elseif (strpos($pwd, ' ') != false) {
                $message['error_pwd'] = "Password should not contain spaces";
            }

            if (empty($conpwd)) {
                $message['error_conpwd'] = "Confirm Password should not be blank..!";
            }

            if ($pwd != $conpwd) {
                $message['error_conpwd'] = " The Password and Confirm Password Not Matching ";
            }




            if (empty($message)) {

                //  $userid = $_SESSION['userid'];


                $cdate = date('Y-m-d');
                $pwd = sha1($pwd);
                $conpwd = sha1($conpwd);

                $sql = "INSERT INTO tbl_users(UserName,Password,RoleId,Status,AddDate) "
                        . "VALUES('$username','$pwd','6','1','$cdate')";
                print_r($sql);

                $db = dbConn();
                $db->query($sql);

                $userid = $db->insert_id;

                $regno = date('Y') . date('m') . date('d') . $userid;
                $_SESSION['RegNumber'] = $regno;

                $sql = "INSERT INTO tbl_customers(RegNo,TitleId,FirstName,LastName,NIC,GenderId,ContactNo,Contact2,HouseNo,StreetName,Area,DistrictId,Email,UserId,AddDate) "
                        . "VALUES('$regno','$title','$fname','$lname','$nic','$gender','$contact','$contact2','$houseno','$streetname','$area','$district','$email','$userid','$cdate')";
                print_r($sql);

                $db->query($sql);
            }
        }
        ?>


        <!--    <h2>Register as Customer</h2>-->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 





            <div class="row mb-3">

                <div class="col-md-4">
                    <label for="title" class="form-label">Title</label>

                    <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM tbl_customer_title";
                    $result = $db->query($sql);
                    ?>

                    <select class="form-select" id="title" name="title">
                        <option value="">Select Title</option>

                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>

                                <option value=<?= $row['TitleId']; ?> <?php if ($row['TitleId'] == @$title) { ?>selected <?php } ?>><?= $row['TitleName'] ?></option>

                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="text-danger">
                        <?= @$message['error_title'] ?>  
                    </div>
                </div>


                <div class="col-md-4">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="fname" value="<?= @$fname ?>">
                    <div class="text-danger">
                        <?= @$message['error_fname'] ?>  
                    </div>



                </div>


                <div class="col-md-4">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="lname" value="<?= @$lname ?>">
                    <div class="text-danger">
                        <?= @$message['error_lname'] ?>  
                    </div>



                </div>

            </div>


            <div class="row mb-3">


                <div class="col-md-4">
                    <label for="nic" class="form-label">NIC</label>
                    <input type="text" class="form-control" id="nic" name="nic" value="<?= @$nic ?>">
                    <div class="text-danger">
                        <?= @$message['error_nic'] ?>  
                    </div>



                </div>



                <div class="col-md-4">

                    <label for="gender" class="form-label">Gender</label>

                    <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM tbl_gender";
                    $result = $db->query($sql);
                    ?>

                    <select class="form-select" id="gender" name="gender">
                        <option value="">Select Gender</option>

                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>

                                <option value=<?= $row['GenderId']; ?> <?php if ($row['GenderId'] == @$gender) { ?>selected <?php } ?>><?= $row['Name'] ?></option>

                                <?php
                            }
                        }
                        ?>


                    </select>
                    <div class="text-danger">
                        <?= @$message['error_gender'] ?>  
                    </div>


                </div>

                <div class="col-md-4">

                    <label for="district" class="form-label">District</label>

                    <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM tbl_district";
                    $result = $db->query($sql);
                    ?>

                    <select class="form-select" id="district" name="district">
                        <option value="">Select District</option>

                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>

                                <option value=<?= $row['DistrictId']; ?> <?php if ($row['DistrictId'] == @$district) { ?>selected <?php } ?>><?= $row['DistrictName'] ?></option>

                                <?php
                            }
                        }
                        ?>


                    </select>
                    <div class="text-danger">
                        <?= @$message['error_district'] ?>  
                    </div>
                </div>






            </div>




            <div class="row mb-3">


                <div class="col-md-4">
                    <label for="house_no" class="form-label">House No</label>
                    <input type="text" class="form-control" id="house_no" name="houseno" value="<?= @$houseno ?>">
                    <div class="text-danger">
                        <?= @$message['error_houseno'] ?>  
                    </div>



                </div>


                <div class="col-md-4">
                    <label for="street_name" class="form-label">Street Name</label>
                    <input type="text" class="form-control" id="street_name" name="streetname" value="<?= @$streetname ?>">
                    <div class="text-danger">
                        <?= @$message['error_streetname'] ?>  
                    </div>



                </div>


                <div class="col-md-4">
                    <label for="area" class="form-label">Area</label>
                    <input type="text" class="form-control" id="area" name="area" value="<?= @$area ?>">
                    <div class="text-danger">
                        <?= @$message['error_area'] ?>  
                    </div>



                </div>






            </div>

            <div class="row mb-3"> 

                <div class="col-md-4">
                    <label for="contact_no" class="form-label">Contact No</label>
                    <input type="text" class="form-control" id="contact_no" name="contact" value="<?= @$contact ?>">
                    <div class="text-danger">
                        <?= @$message['error_contact'] ?>  
                    </div>



                </div>


                <div class="col-md-4">
                    <label for="contact_2" class="form-label">Contact No (Optional) </label>
                    <input type="text" class="form-control" id="contact_2" name="contact2" value="<?= @$contact2 ?>">
                    <div class="text-danger">
                        <?= @$message['error_contact2'] ?>  
                    </div>



                </div>

                <div class="col-md-4">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?= @$email ?>">
                    <div class="text-danger">
                        <?= @$message['error_email'] ?>  
                    </div>



                </div>

            </div>




            <div class="row mb-3">





                <div class="col-md-4">


                    <label for="user_name" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="user_name" name="username" value="<?= @$username ?>">
                    <div class="text-danger">
                        <?= @$message['error_username'] ?>  
                    </div>



                </div>

                <div class="col-md-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="pwd" value="<?= @$pwd ?>">
                    <div class="text-danger">
                        <?= @$message['error_pwd'] ?>  
                    </div>



                </div>




                <div class="col-md-4">
                    <label for="confirmpassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmpassword" name="conpwd" value="<?= @$conpwd ?>">
                    <div class="text-danger">
                        <?= @$message['error_conpwd'] ?>  
                    </div>



                </div>




            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8">
                    <h8 class="h10 text-danger">* Password must be at least 8 characters long. </h8> 
                        <br>
                        <h8 class="h8 text-danger">* Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character </h8> 
                            <br>
                            <h8 class="h8 text-danger">* Password must not be the same as the user name. </h8> 
                                <br> 
                                <h8 class="h8 text-danger">* Password should not contain spaces. </h8> 
                                    </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2">

                                            <a href="register_customer.php" class="btn btn-secondary">Cancel </a>
                                            <button type="submit" class="btn btn-success">Submit</button> 
                                        </div>
                                    </div>

                                    </form>

                                    </section>

                                    </main>



                                    <?php include '../footer.php'; ?> 

