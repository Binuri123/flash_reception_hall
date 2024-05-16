<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>users/users.php">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Employee</li>
            </ol>
        </nav>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '6') {
            ?>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>employee/add.php"><i class="bi bi-plus-circle"></i> New Employee</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    extract($_POST);
    //var_dump($_POST);
    $where = NULL;

    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'search') {
        $employee_no = cleanInput($employee_no);
        $first_name = cleanInput($first_name);
        $last_name = cleanInput($last_name);
        $contact_number = cleanInput($contact_number);
        $email = cleanInput($email);
        $nic = cleanInput($nic);

        if (!empty($employee_no)) {
            //Wild card serach perform using like and %% signs
            $where .= " e.employee_no LIKE '%$employee_no%' AND";
        }
        if (!empty($first_name)) {
            //Wild card serach perform using like and %% signs
            $where .= " e.first_name LIKE '%$first_name%' AND";
        }
        if (!empty($last_name)) {
            //Wild card serach perform using like and %% signs
            $where .= " e.last_name LIKE '%$last_name%' AND";
        }
        if (!empty($designation)) {
            //Exact Search perform using = sign
            $where .= " e.designation_id ='$designation' AND";
        }
        if (!empty($contact_number)) {
            $where .= " (contact_number LIKE '%$contact_number%' OR alternate_number LIKE '%$contact_number%') AND";
        }
        if (!empty($email)) {
            $where .= " email LIKE '%$email%' AND";
        }
        if (!empty($nic)) {
            $where .= " nic LIKE '%$nic%' AND";
        }
        if (!empty($user_status)) {
            //Exact Search perform using = sign
            $where .= " user_status ='$user_status' AND";
        }
        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " WHERE $where";
        }
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <h3>Employee List</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Employee No" name="employee_no" value="<?= @$employee_no ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="First Name" name="first_name" value="<?= @$first_name ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="<?= @$last_name ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Contact Number" name="contact_number" value="<?= @$contact_number ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Email" name="email" value="<?= @$email ?>" style="font-size:13px;">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="NIC" name="nic" value="<?= @$nic ?>" style="font-size:13px;">
                    </div>
                    <div class="col-md-2">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM designation";
                        $result = $db->query($sql);
                        ?>
                        <select name="designation" class="form-control form-select" style="font-size:13px;">
                            <option value="" style="text-align:center">-Designation-</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['designation_id'] ?>" <?php if ($row['designation_id'] == @$designation) { ?> selected <?php } ?>><?= $row['designation_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM user_role";
                        $result = $db->query($sql);
                        ?>
                        <select name="user_role" class="form-control form-select" style="font-size:13px;">
                            <option value="" style="text-align:center">-User Role-</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['user_role_id'] ?>" <?php if ($row['user_role_id'] == @$user_role) { ?> selected <?php } ?>><?= $row['role_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 col-md-2">
                        <select name="user_status" class="form-control form-select" style="font-size:13px;">
                            <option value="" style="text-align:center">-User Status-</option>
                            <option value="Active" <?php if (@$user_status == 'Active') { ?> selected <?php } ?>>Active</option>
                            <option value="Inactive" <?php if (@$user_status == 'Inactive') { ?> selected <?php } ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= SYSTEM_PATH ?>employee/employee.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-sm" style="font-size:13px;">
                    <thead class="bg-secondary">
                        <tr>
                            <th>#</th>
                            <th scope="col">Employee No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Designation</th>
                            <th scope="col">Contact No</th>
                            <th scope="col">Email</th>
                            <th scope="col">NIC</th>
                            <th scope="col">User Role</th>
                            <th scope="col">User Status</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '6') {
                                ?>
                                <th></th>
                                <?php
                            }
                            ?>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM employee e "
                                . "LEFT JOIN district d ON d.district_id=e.district_id "
                                . "LEFT JOIN designation des ON des.designation_id=e.designation_id "
                                . "LEFT JOIN user u ON u.user_id=e.user_id "
                                . "LEFT JOIN user_role ur On ur.user_role_id=u.user_role_id "
                                . "$where ORDER BY e.employee_id ASC";
                        //print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['employee_no'] ?></td>
                                    <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
                                    <td><?= $row['designation_name'] ?></td>
                                    <td><?= $row['contact_number'] ?><br><?= $row['alternate_number'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['nic'] ?></td>
                                    <td><?= $row['role_name'] ?></td>
                                    <td><?= $row['user_status'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '6') {
                                        ?>
                                        <td><a href="edit.php?employee_id=<?= $row['employee_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a></td>
                                        <?php
                                    }
                                    ?>
                                    <td><a href="view.php?employee_id=<?= $row['employee_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php include '../footer.php'; ?>
