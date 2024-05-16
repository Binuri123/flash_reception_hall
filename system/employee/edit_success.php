<?php
include '../header.php';
include '../menu.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $employee_id = $_GET['employee_id'];
        //var_dump($emp_id);
        $updated = $_GET['values'];
        $updated_fields = explode(',', $updated);

        //var_dump($updated_fields);

        if (!empty($employee_id)) {
            $db = dbConn();
            $sql = "SELECT * FROM employee e LEFT JOIN district d ON d.district_id=e.district_id "
                    . "LEFT JOIN designation ON designation.designation_id=e.designation_id "
                    . "LEFT JOIN employment_status s ON s.employement_status_id=e.employement_status_id "
                    . "LEFT JOIN users u ON u.user_id=e.user_id WHERE e.employee_id='$employee_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                //var_dump($row);
                ?>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>users/users.php">User</a></li>
                            <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>employee/employee.php">Employee</a></li>
                            <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>employee/edit.php?employee_id=<?= $employee_id ?>">Employee</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Success</li>
                        </ol>
                    </nav>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>employee/add.php"><i class="bi bi-plus-circle"></i> New Employee</a>
                            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>employee/employee.php"><i class="bi bi-calendar"></i> Search Employee</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-2"></div>
                    <div class="alert alert-warning d-flex align-items-center col-md-8" role="alert">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12" style="text-align:center;">
                                    <h4>Successfully Updated...!!!</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 style="font-weight:bold;margin:0;">Updated Employee Details</h5>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('employee_no', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Employee Number: <?= $row['employee_no'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('title', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Title: <?= $row['title'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('first_name', $updated_fields) || in_array('middle_name', $updated_fields) || in_array('last_name', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Full Name: <?= $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('calling_name', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Calling Name: <?= $row['calling_name'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('house_no', $updated_fields) || in_array('street', $updated_fields) || in_array('city', $updated_fields) || in_array('district', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Address: <?= $row['house_no'] . "," . $row['street'] . "," . $row['city'] . "," . $row['district_name'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('contact_number', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Contact Number: <?= $row['contact_number'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('alternate_number', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Contact Number[Optional]: <?= $row['alternate_number'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('email', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Email: <?= $row['email'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('dob', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Date of Birth: <?= $row['dob'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('nic', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">NIC: <?= $row['nic'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('gender', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Gender: <?= $row['gender'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('designation', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Designation: <?= $row['designation_name'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('recruitment_date', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Recruitment Date: <?= $row['recruitment_date'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('employement_status', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Employment Status: <?= $row['employement_status_name'] ?></p>
                                    <p style="font-weight:bold;margin:0;" class="<?= in_array('user_status', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Active Status: <?= $row['user_status'] ?></p>
                                </div>
                                <div class="col-md-4">
                                    <?php
                                    if (!empty($row['emp_image'])) {
                                        //echo SYSTEM_PATH.'assets/images/employee/'.$row['emp_image'];
                                        ?>
                                        <img src="<?= SYSTEM_PATH ?>assets/images/employee/<?= $row['emp_image'] ?>" style="width:150px;height:150px;">
                                        <?php
                                    } else {
                                        ?>
                                        <img src="<?= SYSTEM_PATH ?>assets/images/employee/noImage.png?>" style="width:150px;height:150px;">
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-md-2"></div>
                    </div>
                </div>
                <?php
            }
        }
    }
    ?>
</main>

<?php include '../footer.php'; ?>