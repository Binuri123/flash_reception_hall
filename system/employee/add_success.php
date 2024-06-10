<?php include '../header.php';?>
<?php include '../menu.php';?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="mt-3 pagetitle">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <h1 class="h4 m-0">Add New Employee</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>employee/add.php"><i class="bi bi-plus-circle"></i> New Employee</a>
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>employee/employee.php"><i class="bi bi-calendar"></i> Search Employee</a>
                </div>
            </div>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>users/users.php">User</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>employee/employee.php">Employee</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>employee/add.php">Add</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Success</li>
            </ol>
        </nav>
    </div>
  <?php
    //check the request method
    if($_SERVER['REQUEST_METHOD']== "GET"){
        
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $employee_no = $_GET['employee_no'];
        
        if(!empty($employee_no)){
            $db = dbConn();
            $sql = "SELECT * FROM employee e LEFT JOIN district d ON d.district_id=e.district_id "
                    . "LEFT JOIN designation ON designation.designation_id=e.designation_id "
                    . "LEFT JOIN employment_status s ON s.employement_status_id=e.employement_status_id "
                    . "LEFT JOIN user u On u.user_id=e.user_id "
                    . "LEFT JOIN user_role ur ON ur.user_role_id=u.user_role_id "
                    . "WHERE e.employee_no='$employee_no'";
            //print_r($sql);
            $result = $db->query($sql);
            if($result->num_rows>0){
                $row = $result->fetch_assoc();
    ?>
    <div class="row">
        <div class="mb-3 col-md-2"></div>
        <div class="alert alert-success col-md-8" role="alert" style="--bs-bg-opacity: .1;">
            <div class="row mb-2">
                <div class="col-md-12" style="text-align:center;">
                    <h4>Successfully Added...!!!</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-bordered border-secondary">
                            <thead class="bg-secondary-light border-dark text-center">
                                <tr>
                                    <th colspan="2">Registered Employee Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Registration Number</td>
                                    <td><?= $row['employee_no'] ?></td>
                                </tr>
                                <tr>
                                    <td>Title</td>
                                    <td><?= $row['title'] ?></td>
                                </tr>
                                <tr>
                                    <td>Full Name</td>
                                    <td><?= $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Calling Name</td>
                                    <td><?= $row['calling_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td><?= $row['house_no'] . "," . $row['street'] . "," . $row['city'] . "," . $row['district_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>Contact Number</td>
                                    <td><?= $row['contact_number'] ?></td>
                                </tr>
                                <?php
                                if($row['alternate_number']!=null){
                                ?>
                                <tr>
                                    <td>Alternate Number</td>
                                    <td><?= $row['alternate_number'] ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td>Alternate Number</td>
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
                <div class="col-md-4">
                    <?php
                    if(!empty($row['emp_image'])){
                        //echo SYSTEM_PATH.'assets/images/employee/'.$row['emp_image'];
                        ?>
                        <img src="<?=SYSTEM_PATH?>assets/images/employee/<?=$row['emp_image']?>" style="width:150px;height:150px;">
                    <?php
                        }else{
                            ?>
                        <img src="<?=SYSTEM_PATH?>assets/images/employee/noImage.png?>" style="width:150px;height:150px;">
                        <?php
                        }
                        
                    ?>
                    
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
 <?php include '../footer.php';?>