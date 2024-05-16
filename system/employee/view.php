<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>users/users.php">User</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>employee/employee.php">Employee</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>employee/add.php"><i class="bi bi-plus-circle"></i> New Employee</a>
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>employee/employee.php"><i class="bi bi-calendar"></i> Search Employee</a>
            </div>
        </div>
    </div>
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $employee_id = $_GET['employee_id'];

        if (!empty($employee_id)) {
            $db = dbConn();
            $sql = "SELECT * FROM employee e "
                    . "LEFT JOIN district d ON d.district_id=e.district_id "
                    . "LEFT JOIN designation des ON des.designation_id=e.designation_id "
                    . "LEFT JOIN employment_status es ON es.employement_status_id = e.employement_status_id "
                    . "LEFT JOIN user u ON u.user_id=e.user_id "
                    . "LEFT JOIN user_role ur On ur.user_role_id=u.user_role_id WHERE e.employee_id='$employee_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                //var_dump($row);
                ?>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="card bg-light col-md-6">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered border-secondary">
                                    <thead class="bg-secondary-light border-dark text-center">
                                        <tr>
                                            <th colspan="2">Employee Details</th>
                                        </tr>
                                        <tr>
                                            <th scope="col">Field</th>
                                            <th scope="col">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <tr>
                                            <td>Employee No</td>
                                            <td><?= $row['employee_no'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Employee Image</td>
                                            <?php
                                            //echo $row['emp_image'];
                                            //echo "../".(empty($row['emp_image']))? 'noImage.jpg' : $row['emp_image'];
                                            ?>
                                            <td><img class="img-fluid" src="../assets/images/employee/<?= empty($row['emp_image']) ? 'noImage.jpg' : $row['emp_image'] ?>" style="width:100px;height:100px;"></td>
                                        </tr>
                                        <tr>
                                            <td>Employee Name</td>
                                            <td><?= $row['title'] . " " . $row['first_name'] . " " . $row['last_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Calling Name</td>
                                            <td><?= $row['calling_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td><?= $row['house_no'] . ",<br>" . $row['street'] . ",<br>" . $row['city'] . ",<br>" . $row['district_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Contact Number</td>
                                            <td><?= $row['contact_number'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Alternate Contact Number</td>
                                            <td><?= $row['alternate_number'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td><?= $row['email'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Date of Birth</td>
                                            <td><?= $row['dob'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>NIC</td>
                                            <td><?= $row['nic'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td><?= $row['gender'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Designation</td>
                                            <td><?= $row['designation_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Recruitment Date</td>
                                            <td><?= $row['recruitment_date'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Employment Status</td>
                                            <td><?= $row['employement_status_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>User Role</td>
                                            <td><?= $row['role_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>User Status</td>
                                            <td><?= $row['user_status'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class=" col-md-3"></div>
                </div>
                <?php
            }
        }
    }
    ?>
</main>
<?php include '../footer.php'; ?>