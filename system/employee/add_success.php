<?php include '../header.php';?>
<?php include '../menu.php';?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>users/users.php">User</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>employee/employee.php">Employee</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>employee/add.php">Add</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Success</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>employee/add.php"><i class="bi bi-plus-circle"></i> New Employee</a>
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>employee/employee.php"><i class="bi bi-calendar"></i> Search Employee</a>
            </div>
        </div>
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
        <div class="alert alert-success col-md-8" role="alert">
            <div class="row">
                <div class="col-md-12" style="text-align:center;">
                    <h4>Successfully Added...!!!</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <h5 style="font-weight:bold;margin:0;">Registered Employee Details</h5>
                    <p style="font-weight:bold;margin:0;">Registration Number: <?= $row['employee_no'] ?></p>
                    <p style="font-weight:bold;margin:0;">Title: <?= $row['title'] ?></p>
                    <p style="font-weight:bold;margin:0;">Full Name: <?= $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">Calling Name: <?= $row['calling_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">Address: <?= $row['house_no'] . "," . $row['street'] . "," . $row['city'] . "," . $row['district_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">Contact Number: <?= $row['contact_number'] ?></p>
                    <p style="font-weight:bold;margin:0;">Alternate Number: <?= $row['alternate_number'] ?></p>
                    <p style="font-weight:bold;margin:0;">Email: <?= $row['email'] ?></p>
                    <p style="font-weight:bold;margin:0;">Date of Birth: <?= $row['dob'] ?></p>
                    <p style="font-weight:bold;margin:0;">NIC: <?= $row['nic'] ?></p>
                    <p style="font-weight:bold;margin:0;">Gender: <?= $row['gender'] ?></p>
                    <p style="font-weight:bold;margin:0;">Designation: <?= $row['designation_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">Recruitment Date: <?= $row['recruitment_date'] ?></p>
                    <p style="font-weight:bold;margin:0;">Employment Status: <?= $row['employement_status_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">User Role: <?= $row['role_name'] ?></p>
                    <p style="font-weight:bold;margin:0;">User Status: <?= $row['user_status'] ?></p>
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