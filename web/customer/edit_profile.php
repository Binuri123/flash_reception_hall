<?php
include 'header.php';
include 'sidebar.php';
?>
<main id="main">
    <section>
        <div class="pagetitle">
            <h1>Update Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Update Profile</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <?php
        $db = dbConn();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $sql = "SELECT * FROM customer WHERE customer_id=" . $_SESSION['customer_id'];
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $title = $row['title_id'];
            $first_name = $row['first_name'];
            $mid_name = $row['middle_name'];
            $last_name = $row['last_name'];
            $house_no = $row['house_no'];
            $street_name = $row['street'];
            $city = $row['city'];
            $district = $row['district_id'];
            $contact_number = $row['contact_number'];
            $alternate_number = $row['alternate_number'];
            $email = $row['email'];
            $nic = $row['nic'];
        }

        extract($_POST);
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'save_changes') {
            //var_dump($_POST);
            //$title = cleanInput($title);
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
                $sql = "SELECT * FROM customer WHERE (contact_number='$contact_number' OR alternate_number = '$contact_number') AND customer_id !=" . $_SESSION['customer_id'];
                //print_r($sql);
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_contact_number'] = "This Contact Number Already Exists...";
                }
            }

            if (!empty($alternate_number) && validateContactNumber($alternate_number)) {
                $message['error_alternate_number'] = "Contact Number is Invalid";
                $db = dbConn();
                $sql = "SELECT * FROM customer WHERE (contact_number='$alternate_number' OR alternate_number = '$alternate_number') AND customer_id !=" . $_SESSION['customer_id'];
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    $message['error_alternate_number'] = "This Contact Number Already Exists...";
                }
            }

            if (!empty($contact_number) && !empty($alternate_number)) {
                if ($contact_number == $alternate_number) {
                    $message['error_alternate_number'] = "Alternate Number Cannot be Same as the Contact Number...";
                }
            }

            if (empty($email)) {
                $message['error_email'] = "The Email Should Not Be Blank...";
            } elseif (validateEmail($email)) {
                $message['error_email'] = "Email is Invalid";
            } else {
                $db = dbConn();
                $sql = "SELECT * from customer WHERE email='$email' AND customer_id !=" . $_SESSION['customer_id'];
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
                    $sql = "SELECT * FROM customer WHERE nic='$nic' AND customer_id !=" . $_SESSION['customer_id'];
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        $message['error_nic'] = "This NIC Already Exists...";
                    }
                }
            }

            if (empty($message)) {
                //echo 'connected';
                $sql2 = "SELECT * FROM customer WHERE customer_id=" . $_SESSION['customer_id'];
                $result2 = $db->query($sql2);
                $row = $result2->fetch_assoc();
                $updated_fields = getUpdatedFields($row, $_POST);
                $updated_fields_string = implode(',', $updated_fields);

                $userid = $_SESSION['userid'];
                $cDate = date('Y-m-d');

                $sql3 = "UPDATE customer SET title_id = '$title',first_name = '$first_name',last_name = '$last_name',house_no = '$house_no',street = '$street_name',city = '$city',district_id = '$district',contact_number = '$contact_number',alternate_number = '$alternate_number',email = '$email',nic = '$nic',update_date = '$cDate' WHERE customer_id=" . $_SESSION['customer_id'];
                echo "<br>";
                //print_r($sql3);
                $db->query($sql3);
            }
        }
        ?>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card bg-light" style="font-size:13px;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h1 class="h4">Update Profile</h1>
                            </div>
                            <div class="col-md-6" style="text-align:right;">
                                <span class="text-danger" style="font-size:13px;">* Required Field</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4 mb-3 mt-3">
                                    <label for="title" class="form-label"><span class="text-danger">*</span> Title</label>
                                </div>
                                <div class="col-md-8 mb-3 mt-3">
                                    <select class="form-control form-select" id="title" name="title" style="font-size:13px;">
                                        <option value="">-Select a Title-</option>
                                        <?php
                                        $db = dbConn();

                                        $sql = "SELECT * FROM customer_titles";
                                        print_r($sql);
                                        $result = $db->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <option value=<?= $row['title_id'] ?> <?php if ($row['title_id'] == @$title) { ?> selected <?php } ?>><?= $row['title_name'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger"><?= @$message['error_title'] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="first_name" class="form-label"><span class="text-danger">*</span> First Name</label>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= @$first_name ?>" style="font-size:13px;">
                                    <div class="text-danger"><?= @$message["error_first_name"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="mid_name" class="form-label">Middle Name [Optional]</label>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <input type="text" class="form-control" id="mid_name" name="mid_name" value="<?= @$mid_name ?>" style="font-size:13px;">
                                    <div class="text-danger"><?= @$message["error_mid_name"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="last_name" class="form-label"><span class="text-danger">*</span> Last Name</label>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?= @$last_name ?>" style="font-size:13px;">
                                    <div class="text-danger"><?= @$message["error_last_name"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="house_no" class="form-label"><span class="text-danger">*</span> House No</label>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <input type="text" class="form-control" id="house_no" name="house_no" value="<?= @$house_no ?>" style="font-size:13px;">
                                    <div class="text-danger"><?= @$message["error_house_no"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="street_name" class="form-label"><span class="text-danger">*</span> Street Name</label>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <input type="text" class="form-control" id="street_name" name="street_name" value="<?= @$street_name ?>" style="font-size:13px;">
                                    <div class="text-danger"><?= @$message["error_street_name"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="city" class="form-label"><span class="text-danger">*</span> City</label>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <input type="text" class="form-control" id="city" name="city" value="<?= @$city ?>" style="font-size:13px;">
                                    <div class="text-danger"><?= @$message["error_city"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="district" class="form-label"><span class="text-danger">*</span> District</label>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <select class="form-control form-select" id="district" name="district" style="font-size:13px;">
                                        <option value="">-Select a District-</option>
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
                                <div class="col-md-4 mb-3">
                                    <label for="contact_number" class="form-label"><span class="text-danger">*</span> Contact Number</label>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= @$contact_number ?>" style="font-size:13px;">
                                    <div class="text-danger"><?= @$message["error_contact_number"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="alternate_number" class="form-label">Alternate Number [Optional]</label>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <input type="text" class="form-control" id="alternate_number" name="alternate_number" value="<?= @$alternate_number ?>" style="font-size:13px;">
                                    <div class="text-danger"><?= @$message["error_alternate_number"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="email" class="form-label"><span class="text-danger">*</span> Email</label>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <input type="email" class="form-control" id="email" name="email" value="<?= @$email ?>" style="font-size:13px;">
                                    <div class="text-danger"><?= @$message["error_email"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="nic" class="form-label"><span class="text-danger">*</span> NIC</label>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <input type="text" class="form-control" id="nic" name="nic" value="<?= @$nic ?>" style="font-size:13px;">
                                    <div class="text-danger"><?= @$message["error_nic"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3" style="text-align:right">
                                    <button type="submit" name="action" value="save_changes" class="btn btn-success btn-sm" style="width:150px;font-size:13px;">Save Changes</button>
                                    <a href="<?= WEB_PATH ?>customer/edit_profile.php" name="action" value="clear" class="btn btn-warning btn-sm" style="width:150px;font-size:13px;">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </section>
</main>
<?php
include 'footer.php';
?>