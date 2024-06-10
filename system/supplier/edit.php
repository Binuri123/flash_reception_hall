<?php
ob_start();
include '../header.php';
include '../menu.php';
include '../assets/phpmail/mail.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="mt-3 pagetitle">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <h1 class="h4 m-0">Update Supplier Details</h1>
            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>supplier/supplier.php"><i class="bi bi-calendar"></i> Search Supplier</a>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>supplier/supplier.php">Supplier</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
        $db = dbConn();
        $sql = "SELECT * FROM supplier WHERE supplier_id='$supplier_id'";
        $result=$db->query($sql);
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $first_name = $row['first_name'];
        $middle_name = $row['middle_name'];
        $last_name = $row['last_name'];
        $house_no = $row['no'];
        $street = $row['street_name'];
        $city = $row['city'];
        $district = $row['district_id'];
        $contact_number = $row['contact_number'];
        $alternate_number = $row['alternate_number'];
        $email = $row['email'];
        $nic = $row['nic'];
        $company_name = $row['company_name'];
        $company_reg_no = $row['company_reg_no'];
        $start_date = $row['agreement_start_date'];
        $end_date = $row['agreement_end_date'];
        
        $sql_service = "SELECT * FROM supplier_service WHERE supplier_id='$supplier_id'";
        $result_service = $db->query($sql_service);
        $service = array();
        while($row_service = $result_service->fetch_assoc()){
            $service[] = $row_service['service_id'];
        }
        
    }
    //Extract the POST Array
    extract($_POST);
    //var_dump($_POST);
    
    //check the request method and identify the submission of the form
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
        // Assign cleaned values to the variables
        $first_name = cleanInput($first_name);
        $first_name = ucfirst($first_name);
        $middle_name = cleanInput($middle_name);
        $middle_name = ucfirst($middle_name);
        $last_name = cleanInput($last_name);
        $last_name = ucfirst($last_name);
        $street = cleanInput($street);
        $street = ucfirst($street);
        $city = cleanInput($city);
        $city = ucfirst($city);
        $contact_number = cleanInput($contact_number);
        $alternate_number = cleanInput($alternate_number);
        $nic = cleanInput($nic);
        $company_name = cleanInput($company_name);
        $company_name = ucfirst($company_name);
        $company_reg_no = cleanInput($company_reg_no);

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
            $sql = "SELECT * from supplier WHERE email='$email' AND supplier_id != '$supplier_id'";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $message['error_email'] = "Email Already Exists";
            }
        }

        if (empty($start_date)) {
            $message['error_start_date'] = "The Agreement Start Date Should Be Selected...";
        }

        if (empty($end_date)) {
            $message['error_end_date'] = "The Agreement End Date Should Be Selected...";
        }

        if (empty($nic)) {
            $message['error_nic'] = "The NIC Should Not Be Blank...";
        } elseif (!validateNICPattern($nic)) {
            $message['error_nic'] = "Invalid NIC...";
        } else {
            $db = dbConn();
            $sql = "SELECT * FROM supplier WHERE nic='$nic' AND supplier_id != '$supplier_id'";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $message['error_nic'] = "This NIC is Already Exists...";
            }
        }

        if (empty($company_name)) {
            $message['error_company_name'] = "The Business Name Should Not Be Blank...";
        }

        if (empty($company_reg_no)) {
            $message['error_company_reg_no'] = "The Company Registration Number Should Be Selected...";
        }
        
        if(empty($service)){
            $message['error_services'] = "Services Should be Selected...";
        }

        //var_dump($message);

        //var_dump($message);
        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');

            if ($cDate < $start_date) {
                $agreement_status = '3';
            } elseif ($cDate >= $start_date && $cDate < $end_date) {
                $agreement_status = '1';
            } elseif ($cDate >= $end_date) {
                $agreement_status = '2';
            }

            //Insert Supplier Details into Supplier Table
            $sql = "UPDATE supplier SET title='$title',first_name='$first_name',middle_name='$middle_name',"
                    . "last_name='$last_name',no='$house_no',street_name='$street',city='$city',district_id='$district',"
                    . "contact_number='$contact_number',alternate_number='$alternate_number',email='$email',nic='$nic'"
                    . ",agreement_start_date='$start_date',agreement_end_date='$end_date'"
                    . ",agreement_status_id='$agreement_status',update_date = '$cDate',update_user='$userid' WHERE supplier_id='$supplier_id'";
            //print_r($sql);
            $db->query($sql);
            
            $sql = "DELETE FROM supplier_service WHERE supplier_id='$supplier_id'";
            $db->query($sql);
            
            //var_dump($service);
            foreach($service as $unit){
                echo $sql = "INSERT INTO supplier_service(supplier_id,service_id) VALUES('$supplier_id','$unit')";
                $db->query($sql);
            }

            header('Location:edit_success.php?supplier_id='.$supplier_id);
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-12">
            <div class="card bg-success" style="--bs-bg-opacity: .1;">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Update Supplier</h4>
                        </div>
                        <div class="col-md-6" style="text-align:right">
                            <p class="text-danger text-right">* Required</p>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="font-size:13px;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row mb-2">
                                    <div class="col">
                                        <label class="form-label"><span class="text-danger">*</span> Title</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="title" id="mr" value="Mr" <?php if (isset($title) && $title == 'Mr') { ?> checked <?php } ?> style="font-size:10px;">
                                            <label class="form-check-label" for="mr" style="font-size:11px;">Mr.</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="title" id="mrs" value="Mrs" <?php if (isset($title) && $title == 'Mrs') { ?> checked <?php } ?> style="font-size:10px;">
                                            <label class="form-check-label" for="mrs"style="font-size:11px;">Mrs.</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="title" id="miss" value="Miss" <?php if (isset($title) && $title == 'Miss') { ?> checked <?php } ?> style="font-size:10px;">
                                            <label class="form-check-label" for="miss" style="font-size:11px;">Miss.</label>
                                        </div>
                                        <div class="text-danger"><?= @$message["error_title"] ?></div>
                                    </div>
                                    <div class="col">
                                        <label for="first_name" class="form-label"><span class="text-danger">*</span> First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= @$first_name ?>" style="font-size:13px;" placeholder="Ex: Kamal">
                                        <div class="text-danger"><?= @$message["error_first_name"] ?></div>
                                    </div>
                                    <div class="col">
                                        <label for="middle_name" class="form-label"> Middle Name [Optional]</label>
                                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= @$middle_name ?>" style="font-size:13px;" placeholder="Ex: Ananda">
                                        <div class="text-danger"><?= @$message["error_middle_name"] ?></div>
                                    </div>
                                    <div class="col">
                                        <label for="last_name" class="form-label"><span class="text-danger">*</span> Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?= @$last_name ?>" style="font-size:13px;" placeholder="Ex: Perera">
                                        <div class="text-danger"><?= @$message["error_last_name"] ?></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="house_no" class="form-label"><span class="text-danger">*</span> House No/Name</label>
                                        <input type="text" class="form-control" id="house_no" name="house_no" value="<?= @$house_no ?>" style="font-size:13px;" placeholder="Ex: No.123">
                                        <div class="text-danger"><?= @$message["error_house_no"] ?></div>
                                    </div>
                                    <div class="col">
                                        <label for="street" class="form-label"><span class="text-danger">*</span> Street Name</label>
                                        <input type="text" class="form-control" id="street" name="street" value="<?= @$street ?>" style="font-size:13px;" placeholder="Ex: First Avenue">
                                        <div class="text-danger"><?= @$message["error_street"] ?></div>
                                    </div>
                                    <div class="col">
                                        <label for="city" class="form-label"><span class="text-danger">*</span> City</label>
                                        <input type="text" class="form-control" id="city" name="city" value="<?= @$city ?>" style="font-size:13px;" placeholder="Ex: Dematagoda">
                                        <div class="text-danger"><?= @$message["error_city"] ?></div>
                                    </div>
                                    <div class="col">
                                        <label for="district" class="form-label"><span class="text-danger">*</span> District</label>
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
                                        <label for="contact_number" class="form-label"><span class="text-danger">*</span> Contact Number</label>
                                        <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= @$contact_number ?>" style="font-size:13px;" placeholder="Ex: 0123456789">
                                        <div class="text-danger"><?= @$message["error_contact_number"] ?></div>
                                    </div>
                                    <div class="col">
                                        <label for="alternate_number" class="form-label">Alternate Number[Optional]</label>
                                        <input type="text" class="form-control" id="alternate_number" name="alternate_number" value="<?= @$alternate_number ?>" style="font-size:13px;" placeholder="Ex: 0123456789">
                                        <div class="text-danger"><?= @$message["error_alternate_number"] ?></div>
                                    </div>
                                    <div class="col">
                                        <label for="email" class="form-label"><span class="text-danger">*</span> Email</label>
                                        <input type="text" class="form-control" id="email" name="email" value="<?= @$email ?>" style="font-size:13px;" placeholder="Ex: kamal@gmail.com">
                                        <div class="text-danger"><?= @$message["error_email"] ?></div>
                                    </div>
                                    <div class="col">
                                        <label for="nic" class="form-label"><span class="text-danger">*</span> NIC</label>
                                        <input type="text" class="form-control" id="nic" name="nic" value="<?= @$nic ?>" style="font-size:13px;" placeholder="Ex: 981234567V">
                                        <div class="text-danger"><?= @$message["error_nic"] ?></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="company_name" class="form-label"><span class="text-danger">*</span> Business/Company Name</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name" value="<?= @$company_name ?>" style="font-size:13px;" placeholder="Ex: Lassana Flora">
                                        <div class="text-danger"><?= @$message["error_company_name"] ?></div>
                                    </div>
                                    <div class="col">
                                        <label for="company_reg_no" class="form-label"><span class="text-danger">*</span> Business Registration No</label>
                                        <input type="text" class="form-control" id="company_reg_no" name="company_reg_no" value="<?= @$company_reg_no ?>" style="font-size:13px;" placeholder="Ex: BR20230802">
                                        <div class="text-danger"><?= @$message["error_company_reg_no"] ?></div>
                                    </div>
                                    <div class="col">
                                        <label for="start_date" class="form-label"><span class="text-danger">*</span> Agreement Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= @$start_date ?>" min="2022-01-01" style="font-size:13px;">
                                        <div class="text-danger"><?= @$message["error_start_date"] ?></div>
                                    </div>
                                    <div class="col">
                                        <label for="end_date" class="form-label"><span class="text-danger">*</span> Agreement End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= @$end_date ?>" min="2022-01-01" style="font-size:13px;">
                                        <div class="text-danger"><?= @$message["error_end_date"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="table-responsive">
                                    <div class="text-danger"><?= @$message['error_services']?></div>
                                    <table class="table table-striped table-secondary table-bordered">
                                        <thead>
                                            <tr style="text-align:center;">
                                                <th scope="col" colspan="2">Services Provide</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $db = dbConn();
                                            $sql_services = "SELECT * FROM service WHERE service_type='outsource'";
                                            $result_services = $db->query($sql_services);
                                            while($row_services=$result_services->fetch_assoc()){
                                                ?>
                                            <tr>
                                                <td><?= $row_services['service_name'] ?></td>
                                                <td>
                                                    <input class="form-check-input" onchange="form.submit()" type="checkbox" id="<?= $row_services['service_id'] ?>" name="service[]" value="<?= $row_services['service_id'] ?>" <?php if (isset($service) && in_array($row_services['service_id'], $service)) { ?>checked <?php } ?>>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mt-3" style="text-align:right">
                                <input type="hidden" name="supplier_id" value="<?= @$supplier_id?>">
                                <button type="submit" name="action" value="save" class="btn btn-success btn-sm" style="font-size:13px;width:150px;">Save Changes</button>
                                <a href="<?= SYSTEM_PATH ?>supplier/add.php" class="btn btn-warning btn-sm" style="font-size:13px;width:150px;">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-3 col-md-2"></div>
    </div>
</main>

<?php
include '../footer.php';
ob_end_flush();
?>