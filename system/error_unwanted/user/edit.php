<?php ob_start()?>
<?php include '../header.php';?>
<?php include '../menu.php';?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-warning"><span data-feather="plus-circle" class="align-text-bottom"></span>New User</button>
                <button type="button" class="btn btn-sm btn-outline-warning"><span data-feather="edit" class="align-text-bottom"></span>Update User</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-warning dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                Search User
            </button>
        </div>
    </div>

    <?php
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        extract($_GET);
        //var_dump($_GET);
        
        $db = dbConn();
        $sql = "SELECT reg_no,title,first_name,last_name,designation_name,status,role_id FROM users u "
                . "LEFT JOIN employee e ON e.user_id=u.user_id "
                . "LEFT JOIN designation d ON d.designation_id=e.designation_id WHERE u.user_id = '$user_id'";
        //print_r($sql);
        $result = $db->query($sql);

        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                //var_dump($row);
                $reg_no = $row['reg_no'];
                $title = $row['title'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $empname = $title." ".$first_name." ".$last_name;
                $designation = $row['designation_name'];
                $status = $row['status'];
                $role = $row['role_id'];
            }
            
        }
    }
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        //extract the array
        extract($_POST);
        
        // Assign cleaned values to the variables
        $reg_no = cleanInput($reg_no);
        $empname = cleanInput($empname);
        $designation = cleanInput($designation);
        $role = cleanInput($role);
        $status = $_POST['status']= isset($status)? '1':'0';

        //Required Validation
        $message = array();
        
        if (empty($role)) {
            $message['error_role'] = "The Role Should Be Selected...";
        }

        if (empty($message)) {
            $db = dbConn();
            $sql = "SELECT role_id as role,status FROM users WHERE user_id ='$user_id'";
            //print_r($sql);
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            //var_dump($row);
            //var_dump($_POST);
            $updated_fields = getUpdatedFields($row,$_POST);
            //var_dump($updated_fields);
            $updated_fields_string = implode(',',$updated_fields);
            //echo 'Connected..!';
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            
            $sql = "UPDATE users SET role_id ='$role',status = '$status',update_user = '$userid',update_date = '$cDate' WHERE user_id='$user_id'";
            //print_r($sql);
            $db->query($sql);
            
            header('Location:edit_success.php?reg_no='.$reg_no.'&user_id='.$user_id.'&values=' . urlencode($updated_fields_string));
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-4"></div>
        <div class="mb-3 col-md-4">
            <h2>Create User Account</h2>
        </div>
        <div class="mb-3 col-md-4"></div>
    </div>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="reg_no" class="form-label">Registration Number</label>
                <input type="text" class="form-control" id="reg_no" name="reg_no" value="<?= @$reg_no ?>" readonly>
                <div class="text-danger"><?= @$message["error_reg_no"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="empname" class="form-label">Name</label>
                <input type="text" class="form-control" id="empname" name="empname" value="<?= @$empname ?>" readonly>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="designation" class="form-label">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation" value="<?= @$designation ?>" readonly>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <label for="role" class="form-label">Role</label>                            
                <select class="form-control form-select" id="role" name="role">
                    <option value="" disabled selected>-Select a Role-</option>
                    <?php
                        $db = dbConn();
                        $sql1 = "SELECT * from user_role WHERE role_id != 7";
                        $result = $db->query($sql1);
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value=<?= $row['role_id']; ?> <?php if ($row['role_id'] == @$role) { ?>selected <?php } ?>><?= $row['role_name'] ?></option>
                            <?php
                        }
                    ?>
                </select>
                <div class="text-danger"><?= @$message["error_role"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?php if (isset($status)&& $status == 1) { ?>checked <?php } ?>>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <div class="text-danger"><?= @$message["error_status"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4" style="text-align:right">
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                <button type="submit" class="btn btn-success" style="width:150px">Add</button>
                <button type="reset" class="btn btn-warning" style="width:150px">Cancel</button>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div> 
    </form>
</main>

 <?php include '../footer.php';?>
<?php ob_end_flush()?>