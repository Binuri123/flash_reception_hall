<?php include '../header.php';?>
<?php include '../menu.php';?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div class="btn-toolbar mb-2 mb-md-0">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Users</a></li>
                <li class="breadcrumb-item"><a href="#">Add</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Success</li>
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
        $reg_no = $_GET['reg_no'];
        $user_id = $_GET['user_id'];
        $password = $_GET['password'];
        $username = $_GET['username'];
        
        if(!empty($reg_no)){
            $db = dbConn();
            $sql = "SELECT e.reg_no,e.title,e.first_name,e.middle_name,e.last_name,designation_name,status FROM employee e LEFT JOIN users u ON e.user_id=u.user_id"
                    . " LEFT JOIN designation d ON d.designation_id=e.designation_id"
                    . " LEFT JOIN user_role r ON r.role_id=u.role_id WHERE u.user_id='$user_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if($result->num_rows>0){
                $row = $result->fetch_assoc();
                //var_dump($row);
    ?>
    <div class="row">
        <div class="mb-3 col-md-2"></div>
        <div class="alert alert-success d-flex align-items-center col-md-8" role="alert">
            <div class="row">
                <div>
                    <h4 class="alert-heading" style="text-indent:150px;">User Successfully Registered...!!!</h4>
                    <h5 class="text-center" style="text-indent:150px;">Registered User Details</h5>
                    <p style="text-indent:200px; font-weight:bold;">Registration Number: <?= $row['reg_no'] ?></p>
                    <p style="text-indent:200px; font-weight:bold;">Title: <?= $row['title'] ?></p>
                    <p style="text-indent:200px; font-weight:bold;">Full Name: <?= $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></p>
                    <p style="text-indent:200px; font-weight:bold;">Username: <?= $username ?></p>
                    <p style="text-indent:200px; font-weight:bold;">Password: <?= $password ?></p>
                    <p style="text-indent:200px; font-weight:bold;">Designation: <?= $row['designation_name'] ?></p>
                    <p style="text-indent:200px; font-weight:bold;">Employment Status: <?= $row['status'] ?></p>
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