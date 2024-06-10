<?php
ob_start();
include '../header.php';
include '../menu.php';
include '../assets/phpmail/mail.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="mt-3 pagetitle">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <h1 class="h4 m-0">Add New Employee</h1>
            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>employee/employee.php"><i class="bi bi-calendar"></i> Search Employee</a>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>users/users.php">User</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>employee/employee.php">Employee</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>
    <?php
    //Extract the POST Array
    extract($_POST);
    //var_dump($_POST);
    //Extract the Uploaded Files Array
    extract($_FILES);
    //var_dump($_FILES);
    
    //check the request method and identify the submission of the form
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "add") {
        // Assign cleaned values to the variables
        $first_name = cleanInput($first_name);
        $middle_name = cleanInput($middle_name);
        $last_name = cleanInput($last_name);
        $calling_name = cleanInput($calling_name);
        $street = cleanInput($street);
        $city = cleanInput($city);
        $contact_number = cleanInput($contact_number);
        $alternate_number = cleanInput($alternate_number);
        $nic = cleanInput($nic);

        //Required Validation
        //Input Format Validation
        //Input Uniqueness Validation
        //Input Accuracy Validation
        $message = array();

        if (!isset($title)) {
            $message['error_title'] = "The Title Should Be Selected...";
        }

        if (empty($first_name)) {
            $message['error_first_name'] = "The First Name Should Not Be Blank...";
        } elseif (validateTextFields($first_name)) {
            $message['error_first_name'] = "Invalid First Name";
        }

        if (!empty($middle_name) && validateTextFields($middle_name)) {
            $message['error_middle_name'] = "Invalid Middle Name";
        }

        if (empty($last_name)) {
            $message['error_last_name'] = "The Last Name Should Not Be Blank...";
        } elseif (validateTextFields($last_name)) {
            $message['error_last_name'] = "Invalid Last Name";
        }

        if (empty($calling_name)) {
            $message['error_calling_name'] = "The Calling Name Should Not Be Blank...";
        } elseif (validateTextFields($calling_name)) {
            $message['error_calling_name'] = "Invalid Calling Name";
        }

        if (empty($house_no)) {
            $message['error_house_no'] = "The House No Should Not Be Blank...";
        }

        if (empty($street)) {
            $message['error_street'] = "The Street Name Should Not Be Blank...";
        }

        if (empty($city)) {
            $message['error_city'] = "The City Should Not Be Blank...";
        } elseif (validateTextFields($city)) {
            $message['error_city'] = "Invalid City Name";
        }

        if (empty($district)) {
            $message['error_district'] = "The District Should Be Seleceted...";
        }

        if (empty($contact_number)) {
            $message['error_contact_number'] = "The Contact Number Should Not Be Blank...";
        } elseif (validateContactNumber($contact_number)) {
            $message['error_contact_number'] = "Invalid Contact Number";
        }

        if (!empty($alternate_number) && validateContactNumber($alternate_number)) {
            $message['error_alternate_number'] = "Invalid Contact Number";
        }

        if (empty($email)) {
            $message['error_email'] = "The Email Should Not Be Blank...";
        } elseif (validateEmail($email)) {
            $message['error_email'] = "Invalid Email Address";
        } else {
            $db = dbConn();
            $sql = "SELECT * from employee WHERE email='$email'";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $message['error_email'] = "Email Already Exists";
            }
        }

        if (empty($dob)) {
            $message['error_dob'] = "The Date of Birth Should Be Selected...";
        } elseif (!getBirthDate($nic, $dob)) {
            $message['error_dob'] = "The Date of Birth is Incorrect...";
        }

        if (empty($nic)) {
            $message['error_nic'] = "The NIC Should Not Be Blank...";
        } elseif (!validateNICPattern($nic)) {
            $message['error_nic'] = "Invalid NIC...";
        } else {
            $db = dbConn();
            $sql = "SELECT * FROM employee WHERE nic='$nic'";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $message['error_nic'] = "This NIC is Already Exists...";
            }
        }

        if (empty($designation)) {
            $message['error_designation'] = "The Designation Should Be Selected...";
        }

        if (empty($recruitment_date)) {
            $message['error_recruitment_date'] = "The Recruitment Date Should Be Selected...";
        }

        if (empty($employment_status)) {
            $message['error_employment_status'] = "The Employment Status Should Be Selected...";
        }

        if (!isset($gender)) {
            $message['error_gender'] = "The Gender Should Be Selected...";
        } elseif (getGender($nic, $gender)) {
            $message['error_gender'] = "The Gender Doesn't match with the NIC...";
        }

        if (empty($user_role)) {
            $message['error_user_role'] = "The User Role Should Be Selected...";
        }

        //var_dump($message);
        //Get the Uploaded Profile Image
        if (empty($message)) {
            if (!empty($_FILES['emp_image']['name'])) {
                $employee_image = uploadFiles("emp_image",$nic,"../assets/images/employee/");
                //var_dump($employee_image);
                $emp_image_name = $employee_image['file_name'];
                if (!empty($employee_image['error_message'])) {
                    $message['error_emp_image'] = $employee_image['error_message'];
                }
            } else {
                $emp_image_name = $prev_image;
            }
        }

        //var_dump($message);
        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');

            if ($user_role != '8') {
                $user_status = 'Active';
            } else {
                $user_status = 'Inactive';
            }

            //Generate a Password for the user account
            $password = generatePassword();
            //Encrypt the password generated
            $enc_password = sha1($password);

            //Insert User Account Details into User Table
            $sql = "INSERT INTO user(username,password,user_role_id,user_status,add_user,add_date) VALUES('$email','$enc_password','$user_role','$user_status','$userid','$cDate')";
            $db->query($sql);
            $new_user_id = $db->insert_id;

            //Insert Employee Details into Employee Table
            $sql = "INSERT INTO employee(title,emp_image,first_name,middle_name,last_name,calling_name,house_no,street,city,district_id,contact_number,alternate_number,email,dob,nic,gender,designation_id,recruitment_date,employement_status_id,user_id,add_user,add_date)VALUES('$title','$emp_image_name','$first_name','$middle_name','$last_name','$calling_name','$house_no','$street','$city','$district','$contact_number','$alternate_number','$email','$dob','$nic','$gender','$designation','$recruitment_date','$employment_status','$new_user_id','$userid','$cDate')";
            //print_r($sql);
            $db->query($sql);

            $new_employee_id = $db->insert_id;
            $employee_no = "EMP" . date('Y') . date('m') . date('d') . $new_employee_id;

            $sql = "UPDATE employee SET employee_no='$employee_no' WHERE employee_id='$new_employee_id'";
            $db->query($sql);

            //Send an Email mentioning the Username and Password for the User Account
            $to = $email;
            $recepient_name = $first_name . " " . $last_name;
            $subject = 'Flash Reception Hall - Employee Registration';
            $body = "<p>Welcome and Thank You for Joining with Flash Reception Hall</p>";
            $body .= "<br><br>";
            $body .= "<p>Your Account will be created and activated in a while and you will be able to Log in by using the following credentials</p>";
            $body .= "<br><br>";
            $body .= "Username: " . $email . "<br>";
            $body .= "Password: " . $password;
            $body .= "<br><br>";
            $body .= "You can visit the Login using the following link<>br";
            $body .= "<p>http://localhost/flash_reception_hall/system/login.php</p>";
            $body .= "<br><br>";
            $body .= "Once you logged into the system we recommend you to change your password.";
            $body .= "<br><br>";
            $body .= "<p>Thank You,</p><br>";
            $body .= "<p>Yours Sincerely,</p><br>";
            $body .= "<p>HR Manager,</p><br>";
            $body .= "<p>Flash Reception Hall.</p>";
            $alt_body = "<p>Employee Successfully Registered</p>";
            send_email($to, $recepient_name, $subject, $body, $alt_body);

            header('Location:add_success.php?employee_no=' . $employee_no);
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-12">
            <div class="card bg-success" style="--bs-bg-opacity: .1;">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Add New Employee</h4>
                        </div>
                        <div class="col-md-6" style="text-align:right">
                            <p class="text-danger text-right">* Required</p>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="font-size:13px;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row mb-2">
                            <div class="col">
                                <label for="emp_image" class="form-label"><span class="text-danger">*</span>Photo</label><br>
                                <input class="form-control" type="file" name="emp_image" id="emp_image" style="font-size:13px;">
                                <?php
                                if (!empty($_FILES)) {
                                    $prev_image = $_FILES['emp_image']['name'];
                                }
                                ?>
                                <input type="hidden" name="prev_image" value="<?= @$prev_image ?>" style="font-size:13px;">
                                <div class="text-danger"><?= @$message["error_emp_image"] ?></div>
                            </div>
                            <div class="col">
                                <label class="form-label"><span class="text-danger">*</span>Title</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="title" id="mr" value="Mr" <?php if (isset($title) && $title == 'Mr') { ?> checked <?php } ?> style="font-size:13px;">
                                    <label class="form-check-label" for="mr">Mr.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="title" id="mrs" value="Mrs" <?php if (isset($title) && $title == 'Mrs') { ?> checked <?php } ?> style="font-size:13px;">
                                    <label class="form-check-label" for="mrs">Mrs.</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="title" id="miss" value="Miss" <?php if (isset($title) && $title == 'Miss') { ?> checked <?php } ?> style="font-size:13px;">
                                    <label class="form-check-label" for="miss">Miss.</label>
                                </div>
                                <div class="text-danger"><?= @$message["error_title"] ?></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="first_name" class="form-label"><span class="text-danger">*</span>First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= @$first_name ?>" style="font-size:13px;" placeholder="Ex: Kamal">
                                <div class="text-danger"><?= @$message["error_first_name"] ?></div>
                            </div>
                            <div class="col">
                                <label for="middle_name" class="form-label">Middle Name [Optional]</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= @$middle_name ?>" style="font-size:13px;" placeholder="Ex: Ananda">
                                <div class="text-danger"><?= @$message["error_middle_name"] ?></div>
                            </div>
                            <div class="col">
                                <label for="last_name" class="form-label"><span class="text-danger">*</span>Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= @$last_name ?>" style="font-size:13px;" placeholder="Ex: Perera">
                                <div class="text-danger"><?= @$message["error_last_name"] ?></div>
                            </div>
                            <div class="col">
                                <label for="calling_name" class="form-label"><span class="text-danger">*</span>Calling Name</label>
                                <input type="text" class="form-control" id="calling_name" name="calling_name" value="<?= @$calling_name ?>" style="font-size:13px;" placeholder="Ex: Kamal">
                                <div class="text-danger"><?= @$message["error_calling_name"] ?></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="house_no" class="form-label"><span class="text-danger">*</span>House No/Name</label>
                                <input type="text" class="form-control" id="house_no" name="house_no" value="<?= @$house_no ?>" style="font-size:13px;" placeholder="Ex: No.123">
                                <div class="text-danger"><?= @$message["error_house_no"] ?></div>
                            </div>
                            <div class="col">
                                <label for="street" class="form-label"><span class="text-danger">*</span>Street Name</label>
                                <input type="text" class="form-control" id="street" name="street" value="<?= @$street ?>" style="font-size:13px;" placeholder="Ex: First Avenue">
                                <div class="text-danger"><?= @$message["error_street"] ?></div>
                            </div>
                            <div class="col">
                                <label for="city" class="form-label"><span class="text-danger">*</span>City</label>
                                <input type="text" class="form-control" id="city" name="city" value="<?= @$city ?>" style="font-size:13px;" placeholder="Ex: Dematagoda">
                                <div class="text-danger"><?= @$message["error_city"] ?></div>
                            </div>
                            <div class="col">
                                <label for="district" class="form-label"><span class="text-danger">*</span>District</label>
                                <select class="form-control form-select" id="district" name="district" style="font-size:13px;">
                                    <option value="" style="text-align:center;">-Select a District-</option>
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
                        <div class="row mb-2">
                            <div class="col">
                                <label for="contact_number" class="form-label"><span class="text-danger">*</span>Contact Number</label>
                                <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= @$contact_number ?>" style="font-size:13px;" placeholder="Ex: 0123456789">
                                <div class="text-danger"><?= @$message["error_contact_number"] ?></div>
                            </div>
                            <div class="col">
                                <label for="alternate_number" class="form-label">Alternate Number[Optional]</label>
                                <input type="text" class="form-control" id="alternate_number" name="alternate_number" value="<?= @$alternate_number ?>" style="font-size:13px;" placeholder="Ex: 0123456789">
                                <div class="text-danger"><?= @$message["error_alternate_number"] ?></div>
                            </div>
                            <div class="col">
                                <label for="email" class="form-label"><span class="text-danger">*</span>Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?= @$email ?>" style="font-size:13px;" placeholder="Ex: kamal@gmail.com">
                                <div class="text-danger"><?= @$message["error_email"] ?></div>
                            </div>
                            <div class="col">
                                <label for="nic" class="form-label"><span class="text-danger">*</span>NIC</label>
                                <input type="text" class="form-control" id="nic" name="nic" value="<?= @$nic ?>" style="font-size:13px;" placeholder="Ex: 981234567V">
                                <div class="text-danger"><?= @$message["error_nic"] ?></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="dob" class="form-label"><span class="text-danger">*</span>Date of Birth</label>
                                <?php
                                $today = date('Y-m-d');
                                $mindate = date('Y-m-d', strtotime('-60 years', strtotime($today)));
                                $maxdate = date('Y-m-d', strtotime('-18 years', strtotime($today)));
                                ?>
                                <input type="date" class="form-control" id="dob" name="dob" value="<?= @$dob ?>" min="<?= $mindate ?>" max="<?= $maxdate ?>" style="font-size:13px;">
                                <div class="text-danger"><?= @$message["error_dob"] ?></div>
                            </div>
                            <div class="col">
                                <label class="form-label"><span class="text-danger">*</span>Gender</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="Male" <?php if (isset($gender) && @$gender == 'Male') { ?> checked <?php } ?> style="font-size:13px;">
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="Female" <?php if (isset($gender) && (@$gender == 'Female')) { ?> checked <?php } ?> style="font-size:13px;">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                                <div class="text-danger"><?= @$message["error_gender"] ?></div>
                            </div>  
                            <div class="col">
                                <label for="employment_status" class="form-label"><span class="text-danger">*</span>Employment Status</label>                            
                                <select class="form-control form-select" id="employment_status" name="employment_status" style="font-size:13px;">
                                    <option value="" style="text-align:center;">-Select a Status-</option>
                                    <?php
                                    $db = dbConn();
                                    $sql1 = "SELECT * from employment_status";
                                    $result = $db->query($sql1);
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value=<?= $row['employement_status_id']; ?> <?php if ($row['employement_status_id'] == @$employment_status) { ?> selected <?php } ?>><?= $row['employement_status_name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="text-danger"><?= @$message["error_employment_status"] ?></div>
                            </div>
                            <div class="col">
                                <label for="recruitment_date" class="form-label"><span class="text-danger">*</span>Recruitment Date</label>
                                <input type="date" class="form-control" id="recruitment_date" name="recruitment_date" value="<?= @$recruitment_date ?>" min="2022-01-01" max="<?php echo date('Y-m-d') ?>" style="font-size:13px;">
                                <div class="text-danger"><?= @$message["error_recruitment_date"] ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="designation" class="form-label"><span class="text-danger">*</span>Designation</label>                            
                                <select class="form-control form-select" id="designation" name="designation" style="font-size:13px;">
                                    <option value="" style="text-align:center;">-Select a Designation-</option>
                                    <?php
                                    $db = dbConn();
                                    $sql1 = "SELECT * from designation";
                                    $result = $db->query($sql1);
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value=<?= $row['designation_id']; ?> <?php if ($row['designation_id'] == @$designation) { ?> selected <?php } ?>><?= $row['designation_name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="text-danger"><?= @$message["error_designation"] ?></div>
                            </div>
                            <div class="col">
                                <label for="user_role" class="form-label"><span class="text-danger">*</span>User Role</label>
                                <select class="form-control form-select" id="user_role" name="user_role" style="font-size:13px;">
                                    <option value="" style="text-align:center;">-Select a Role-</option>
                                    <?php
                                    $db = dbConn();
                                    $sql1 = "SELECT * from user_role WHERE user_role_id != '7' AND user_role_id != '1'";
                                    $result = $db->query($sql1);
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value=<?= $row['user_role_id']; ?> <?php if ($row['user_role_id'] == @$user_role) { ?> Selected <?php } ?>><?= $row['role_name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div class="text-danger"><?= @$message["error_user_role"] ?></div>
                            </div>
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                        <div class="row">
                            <div class="mb-2" style="text-align:right">
                                <button type="submit" name="action" value="add" class="btn btn-success btn-sm" style="font-size:13px;width:100px;">Add</button>
                                <a href="<?= SYSTEM_PATH ?>employee/add.php" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include '../footer.php';
ob_end_flush();
?>