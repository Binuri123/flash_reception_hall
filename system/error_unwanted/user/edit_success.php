<?php include '../header.php';?>
<?php include '../menu.php';?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div class="btn-toolbar mb-2 mb-md-0">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Users</a></li>
                <li class="breadcrumb-item"><a href="#">Update</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update Success</li>
            </ol>
        </nav>
    </div>
  </div>

  <?php
    //check the request method
    if($_SERVER['REQUEST_METHOD']== "GET"){
        
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $user_id = $_GET['user_id'];
        $reg_no = $_GET['reg_no'];
        $updated = $_GET['values'];
        $updated_fields = explode(',',$updated);
        
        //var_dump($updated_fields);
        
            $db = dbConn();
            $sql = "SELECT reg_no,title,first_name,last_name,u.role_id as role,role_name,status FROM employee e "
                    . "INNER JOIN users u ON u.user_id=e.user_id "
                    . "LEFT JOIN user_role r ON r.role_id=u.role_id WHERE u.user_id='$user_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if($result->num_rows>0){
                $row = $result->fetch_assoc();
                //var_dump($row);
    ?>
    <div class="row">
        <div class="mb-3 col-md-2"></div>
        <div class="alert alert-warning d-flex align-items-center col-md-8" role="alert">
            <div class="row">
                <div>
                    <h4 class="alert-heading" style="text-indent:150px;">User Successfully Updated...!!!</h4>
                    <h5 class="text-center" style="text-indent:150px;">Updated User Details</h5>
                    <p style="text-indent:200px; font-weight:bold;" class="<?= in_array('reg_no', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Registration Number: <?= $row['reg_no'] ?></p>
                    <p style="text-indent:200px; font-weight:bold;" class="<?= in_array('title', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Title: <?= $row['title'] ?></p>
                    <p style="text-indent:200px; font-weight:bold;" class="<?= in_array('first_name', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Full Name: <?= $row['first_name'] . " " . $row['last_name'] ?></p>
                    <p style="text-indent:200px; font-weight:bold;" class="<?= in_array('role', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Role: <?= $row['role_name'] ?></p>
                    <p style="text-indent:200px; font-weight:bold;" class="<?= in_array('status', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Active Status: <?= ($row['status'])? "Active":"Inactive" ?></p>
                </div>
            </div>
        <div class="mb-3 col-md-2"></div>
        </div>
    </div>
    <?php
            }
    }    
  ?>
        
        
</main>

 <?php include '../footer.php';?>