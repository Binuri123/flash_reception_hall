<?php ob_start()?>
<?php include '../header.php';?>
<?php include '../menu.php';?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
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
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        //extract the array
        extract($_POST);
        // Assign cleaned values to the variables
        $reg_no = cleanInput($reg_no);
        $role = cleanInput($role);

        //Required Validation
        $message = array();
        if (empty($reg_no)) {
            $message['error_emp_id'] = "The Employee ID Should Be Selected...";
        }
        if (empty($role)) {
            $message['error_role'] = "The Role Should Be Selected...";
        }
//            if(!isset($status)){
//                $message['error_status'] = "The Active Status Should Be Select...";
//            }

        if (empty($message)&&isset($status)) {
            $db = dbConn();
            //echo 'Connected..!';
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $password = generatePassword();
            $pwd = $password;
            $username = generateUsername();
            
            $password = sha1($password);
            
            $sql = "INSERT INTO users(username,password,role_id,status,add_user,add_date)VALUES('$username','$password','$role','$status','$userid','$cDate')";
            //print_r($sql);
            $db->query($sql);
            $new_user_id = $db->insert_id;
            //echo $new_user_id;
            $sql = "UPDATE employee SET user_id = $new_user_id WHERE reg_no = '$reg_no'";
            //print_r($sql);
            $db->query($sql);
            header('Location:add_success.php?reg_no='.$reg_no.'&user_id='.$new_user_id.'&password='.$pwd.'&username='.$username);
        }else{
            $message['error_status'] = "The User Should Be Active...";
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
                <select class="form-control form-select" id="reg_no" name="reg_no">
                    <option value="" disabled selected>-Select Reg No-</option>
                    <?php
                        $db = dbConn();
                        $sql1 = "SELECT reg_no from employee WHERE user_id=0";
                        $result = $db->query($sql1);
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value=<?= $row['reg_no']; ?> <?php if ($row['reg_no'] == @$reg_no) { ?>selected <?php } ?>><?= $row['reg_no'] ?></option>
                            <?php
                        }
                    ?>
                </select>
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
                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?php if (isset($status)) { ?>checked <?php } ?>>
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <div class="text-danger"><?= @$message["error_status"] ?></div>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-4"></div>
            <div class="mb-3 col-md-4" style="text-align:right">
                <button type="submit" class="btn btn-success" style="width:150px">Add</button>
                <button type="reset" class="btn btn-warning" style="width:150px">Cancel</button>
            </div>
            <div class="mb-3 col-md-4"></div>
        </div> 
    </form>
</main>

 <?php include '../footer.php';?>
<?php ob_end_flush()?>