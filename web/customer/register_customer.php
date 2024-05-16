<?php
ob_start();
session_start();
include '../header.php';
?>
<main id="main">
    <section style="margin-top:20px;font-size:13px;">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET)) {
            extract($_GET);
            $db = dbConn();
            $sql = "SELECT * FROM check_availability c LEFT JOIN hall h ON h.hall_id=c.hall_id "
                    . "LEFT JOIN event e ON e. event_id=c.event_id "
                    . "WHERE check_availability_id=$check_availability_id";
            //print_r($sql);
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $hall_id = $row['hall_id'];
            $hall_name = $row['hall_name'];
            $event_name = $row['event_name'];
            $event_date = $row['event_date'];
        }
        extract($_POST);
//check the request method
        if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'register') {
            //extract the array
            // Assign cleaned values to the variables
            $first_name = cleanInput($first_name);
            $first_name = ucfirst($first_name);
            $mid_name = cleanInput($mid_name);
            $mid_name = ucfirst($mid_name);
            $last_name = cleanInput($last_name);
            $last_name = ucfirst($last_name);
            $street_name = cleanInput($street_name);
            $street_name = ucfirst($street_name);
            $city = cleanInput($city);
            $city = ucfirst($city);
            $contact_number = cleanInput($contact_number);
            $alternate_number = cleanInput($alternate_number);
            $nic = cleanInput($nic);

            //Required Validation
            $message = array();
            if (empty($title)) {
                $message['error_title'] = "The Title Should Be Selected...";
            }
            if (empty($first_name)) {
                $message['error_first_name'] = "The First Name Should Not Be Blank...";
            } elseif (validateTextFields($first_name)) {
                $message['error_first_name'] = "Input is Invalid...<br>First Name should only contain letters...";
            }

            if (!empty($mid_name) && validateTextFields($mid_name)) {
                $message["error_mid_name"] = "Input is Invalid...<br>Middle Name should only contain letters...";
            }

            if (empty($last_name)) {
                $message['error_last_name'] = "The Last Name Should Not Be Blank...";
            } elseif (validateTextFields($last_name)) {
                $message['error_last_name'] = "Input is Invalid...<br>Last Name should only contain letters...";
            }

            if (empty($house_no)) {
                $message['error_house_no'] = "The House No Should Not Be Blank...";
            }

            if (empty($street_name)) {
                $message['error_street_name'] = "The Street Name Should Not Be Blank...";
            }elseif(validateTextFieldswithDigits($street_name)){
                $message['error_street_name'] = "The Street Name Should Not Be Contain Only Digits...";
            }

            if (empty($city)) {
                $message['error_city'] = "The City Should Not Be Blank...";
            } elseif (validateTextFields($city)) {
                $message['error_city'] = "Input is Invalid....<br>City Name should only contain letters...";
            }

            if (empty($district)) {
                $message['error_district'] = "The District Should Be Selected...";
            }

            if (empty($contact_number)) {
                $message['error_contact_number'] = "The Contact Number Should Not Be Blank...";
            } elseif (validateContactNumber($contact_number)) {
                $message['error_contact_number'] = "Contact Number is Invalid";
            } else {
                $db = dbConn();
                $sql = "SELECT * FROM customer WHERE contact_number='$contact_number' OR alternate_number = '$contact_number'";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_contact_number'] = "This Contact Number Already Exists...";
                }
            }

            if (!empty($alternate_number) && validateContactNumber($alternate_number)) {
                $message['error_alternate_number'] = "Contact Number is Invalid";
                $db = dbConn();
                $sql = "SELECT * FROM customer WHERE contact_number='$alternate_number' OR alternate_number = '$alternate_number'";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_alternate_number'] = "This Contact Number Already Exists...";
                }
            }
            
            if(!empty($alternate_number) && !empty($contact_number)){
                if($alternate_number == $contact_number){
                    $message['error_alternate_number'] = "Alternate Number Should Not be Same as Contact Number";
                }
            }

            if (empty($email)) {
                $message['error_email'] = "The Email Should Not Be Blank...";
            } elseif (validateEmail($email)) {
                $message['error_email'] = "Email is Invalid";
            } else {
                $db = dbConn();
                $sql = "SELECT * from customer WHERE email='$email'";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_email'] = "This Email Already Exists";
                }
            }

            if (empty($nic)) {
                $message['error_nic'] = "The NIC Should Not Be Blank...";
            } else {
                $nic_info = validateNIC($nic);
                if ($nic_info == FALSE) {
                    $message['error_nic'] = "Invalid NIC...";
                } else {
                    $db = dbConn();
                    $sql = "SELECT * FROM customer WHERE nic='$nic'";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        $message['error_nic'] = "This NIC Already Exists...";
                    }
                }
            }
//            elseif(!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d, ]+$/',$username)){
//                $message['error_username'] = "The Username Should Not Be Contain Only Digits...";
//            }
            if (empty($username)) {
                $message['error_username'] = "The Username Should Not Be Blank...";
            } elseif(strpos($username,' ')){
                $message['error_username'] = "The Username Should Not Contain Spaces...";
            } else{
                $db = dbConn();
                $sql = "SELECT username FROM user WHERE username='$username' AND user_role_id =7";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_username'] = "This Username is Already Taken...";
                }
            }

            if (empty($password)) {
                $message['error_password'] = "The Password Should Not Be Blank...";
            } else {
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

            if (empty($confirm_pwd)) {
                $message['error_confirm_pwd'] = "The Confirm Password Should Not Be Blank...";
            } else if ($password != $confirm_pwd) {
                $message['error_confirm_pwd'] = "The Password and Confirm Password Should be Matched";
            }

            if (empty($acceptance)) {
                $message["error_acceptance"] = "You Should Agree to the Terms and Conditions to Register";
            }

            //var_dump($message);
            //print_r($acceptance);
            if (empty($message) && $acceptance == 'Accepted') {
                //echo 'inside';
                $db = dbConn();
                //echo $db;
                $cDate = date('Y-m-d');
                //print_r($cDate);
                $password_length = strlen($password);
                $password = sha1($password);
                $confirm_pwd = sha1($confirm_pwd);
                $sql = "INSERT INTO user(username,password,user_role_id,user_status,add_date)VALUES('$username','$password','7','Active','$cDate')";
                //print_r($sql);
                $db->query($sql);

                $userid = $db->insert_id;
                $sql = "UPDATE user SET add_user='$userid' WHERE user_id='$userid'";
                $db->query($sql);

                $sql = "INSERT INTO customer(title_id,first_name,middle_name,last_name,house_no,street,city,district_id,contact_number,alternate_number,email,nic,"
                        . "acceptance,user_id,add_date)VALUES('$title','$first_name','$mid_name','$last_name','$house_no','$street_name',"
                        . "'$city','$district','$contact_number','$alternate_number','$email','$nic','$acceptance','$userid','$cDate')";
                $db->query($sql);
                //print_r($sql);
                $customerid = $db->insert_id;
                $customer_no = "CUS" . date('Y') . date('m') . date('d') . $customerid;

                $sql = "UPDATE customer SET customer_no='$customer_no' WHERE customer_id='$customerid'";
                //print_r($sql);
                $db->query($sql);
                $to = $email;
                $recepient_name = $first_name . " " . $last_name;
                $subject = 'Flash Reception Hall - Thank You For Registering';
                $body = "<p>Welcome and Thank You for Registering at Flash Reception Hall</p>";
                $body .= "<br><br>";
                $body .= "<p>Your Account has now been Created and You can Log in by using your username and password by visiting our website or at the following URL:</p>";
                $body .= "<br><br>";
                if(!empty($check_availability_id)){
                    $body .= "<p>http://localhost/flash_reception_hall/web/customer/login.php?check_availability_id='".$check_availability_id."</p>";
                }else{
                    $body .= "<p>http://localhost/flash_reception_hall/web/customer/login.php</p>";
                }
                $body .= "<p>Upon logging in, you will be able to access other services including make reservations, make payments, printing invoices and editing your account information.</p>";
                $body .= "<br><br>";
                $body .= "<p>Thank You,</p><br><p>Flash Reception Hall.</p>";
                $alt_body = "<p>You Have Successfully Registered</p>";
                send_email($to, $recepient_name, $subject, $body, $alt_body);
                if(!empty($check_availability_id)){
                    header('Location:register_success.php?customer_no=' . $customer_no . '&password_length=' . $password_length. '&check_availability_id=' . $check_availability_id. '&hall_id='.$hall_id);
                }else{
                    header('Location:register_success.php?customer_no=' . $customer_no . '&password_length=' . $password_length);
                }
            }
        }
        ?>
        <div class="row mt-3">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <?php
                if (!empty($hall_name)) {
                    ?>
                    <div class="row mt-5">
                        <div class="col-md-8">

                            <h6 style="padding-bottom:10px;"><strong><i>--- You have selected the <?= $hall_name ?> for Your <?= $event_name ?> on <?= $event_date ?> ---</i></strong></h6>
                            <input type="hidden" name="hall" value="<?= @$hall ?>">
                            <input type="hidden" name="event" value="<?= @$event ?>">
                            <input type="hidden" name="event_date" value="<?= @$event_date ?>">
                        </div>
                        <div class="col-md-4">
                            <a href="<?= WEB_PATH ?>check_availability/availability_check.php?check_availability_id=<?=$check_availability_id?>" style="color:blue;text-decoration:underline">Change</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 mt-1">Register As a New Customer</h1>
                    <p class="text-danger">* Required</p>
                </div>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="title" class="form-label"><span class="text-danger">*</span> Title</label>
                            <select class="form-control" id="title" name="title" style="font-size:13px;">
                                <option value="" disabled selected>-Select a Title-</option>
                                <?php
                                $db = dbConn();

                                $sql = "SELECT * FROM customer_titles";
                                //print_r($sql);
                                $result = $db->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value=<?= $row['title_id'] ?> <?php if ($row['title_id'] == @$title) { ?> selected <?php } ?>><?= $row['title_name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <div class="text-danger"><?= @$message["error_title"] ?></div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="first_name" class="form-label"><span class="text-danger">*</span> First Name</label>
                            <input type="text" class="form-control" placeholder="Ex: Kamal" id="first_name" name="first_name" value="<?= @$first_name ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_first_name"] ?></div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="mid_name" class="form-label">Middle Name [Optional]</label>
                            <input type="text" class="form-control" placeholder="Ex: Priyantha" id="mid_name" name="mid_name" value="<?= @$mid_name ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_mid_name"] ?></div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="last_name" class="form-label"><span class="text-danger">*</span> Last Name</label>
                            <input type="text" class="form-control" placeholder="Ex: Perera" id="last_name" name="last_name" value="<?= @$last_name ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_last_name"] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="house_no" class="form-label"><span class="text-danger">*</span> House No</label>
                            <input type="text" class="form-control" placeholder="Ex: No.219/7" id="house_no" name="house_no" value="<?= @$house_no ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_house_no"] ?></div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="street_name" class="form-label"><span class="text-danger">*</span> Street Name</label>
                            <input type="text" class="form-control" placeholder="Ex: First Lane" id="street_name" name="street_name" value="<?= @$street_name ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_street_name"] ?></div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="city" class="form-label"><span class="text-danger">*</span> City</label>
                            <input type="text" class="form-control" placeholder="Ex: Dematagoda" id="city" name="city" value="<?= @$city ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_city"] ?></div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="district" class="form-label"><span class="text-danger">*</span> District</label>
                            <select class="form-control form-select" id="district" name="district" style="font-size:13px;">
                                <option value="" disabled selected >-Select a District-</option>
                                <?php
                                $db = dbConn();
                                $sql1 = "SELECT * from district";
                                $result = $db->query($sql1);
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value=<?= $row['district_id']; ?> <?php if ($row['district_id'] == @$district) { ?> selected <?php } ?>><?= $row['district_name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <div class="text-danger"><?= @$message["error_district"] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="contact_number" class="form-label"><span class="text-danger">*</span> Contact Number</label>
                            <input type="text" class="form-control" placeholder="Ex: 0712345678" id="contact_number" name="contact_number" value="<?= @$contact_number ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_contact_number"] ?></div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="alternate_number" class="form-label">Alternate Number [Optional]</label>
                            <input type="text" class="form-control" placeholder="Ex: 0712345678" id="alternate_number" name="alternate_number" value="<?= @$alternate_number ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_alternate_number"] ?></div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="email" class="form-label"><span class="text-danger">*</span> Email</label>
                            <input type="email" class="form-control" placeholder="Ex: abc@gmail.com" id="email" name="email" value="<?= @$email ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_email"] ?></div>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="nic" class="form-label"><span class="text-danger">*</span> NIC</label>
                            <input type="text" class="form-control" placeholder="Ex: 97XXXXXXXV OR 1997XXXXXXXX" id="nic" name="nic" value="<?= @$nic ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_nic"] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="username" class="form-label"><span class="text-danger">*</span> Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= @$username ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_username"] ?></div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="password" class="form-label"><span class="text-danger">*</span> Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?= @$password ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_password"] ?></div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="confirm_pwd" class="form-label"><span class="text-danger">*</span> Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" value="<?= @$confirm_pwd ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message["error_confirm_pwd"] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <div class="form-check form-check-inline" style="font-size:13px;">
                                <input class="form-check-input" type="checkbox" id="status" name="acceptance" value="Accepted" <?php if (isset($acceptance) && $acceptance == 'Accepted') { ?>checked <?php } ?>>
                                <label class="form-check-label" for="acceptance">I Agree to the <a href="../termsandconditions.php" style="color:blue;text-decoration:underline;">Terms and Conditions</a></label>
                            </div>
                            <div class="text-danger"><?= @$message["error_acceptance"] ?></div>
                        </div>
                        <div class="mb-3 col-md-6" style="text-align:right">
                            <input type="hidden" name="hall_id" value="<?= @$hall_id ?>">
                            <input type="hidden" name="check_availability_id" value="<?= @$check_availability_id ?>">
                            <button type="submit" name="action" value="register" class="btn btn-success" style="font-size:13px;width:100px;">Register</button>
                            <button type="submit" name="action" value="clear" class="btn btn-warning" style="font-size:13px;width:100px;">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php 
include '../footer.php';
ob_end_flush();
?>