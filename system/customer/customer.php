<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>users/users.php">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Customer</li>
            </ol>
        </nav>
    </div>
    <?php
    extract($_POST);
    //var_dump($_POST);
    $where = NULL;
    //echo 'outside';
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'search') {
        //echo 'inside';
        $customer_no = cleanInput($customer_no);
        $first_name = cleanInput($first_name);
        $last_name = cleanInput($last_name);
        $contact_number = cleanInput($contact_number);
        $email = cleanInput($email);
        $nic = cleanInput($nic);

        if (!empty($customer_no)) {
            //Wild card serach perform using like and %% signs
            $where .= " c.customer_no LIKE '%$customer_no%' AND";
        }
        if (!empty($first_name)) {
            //Wild card serach perform using like and %% signs
            $where .= " c.first_name LIKE '%$first_name%' AND";
        }
        if (!empty($last_name)) {
            //Wild card serach perform using like and %% signs
            $where .= " c.last_name LIKE '%$last_name%' AND";
        }
        if (!empty($contact_number)) {
            $where .= " (c.contact_number LIKE '%$contact_number%' OR c.alternate_number LIKE '%$contact_number%') AND";
        }
        if (!empty($email)) {
            $where .= " c.email LIKE '%$email%' AND";
        }
        if (!empty($nic)) {
            $where .= " c.nic LIKE '%$nic%' AND";
        }
        if (!empty($user_status)) {
            //Exact Search perform using = sign
            $where .= " u.user_status ='$user_status' AND";
        }
        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " WHERE $where";
        }
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <h3>Customer List</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="Customer No" name="customer_no" value="<?= @$customer_no ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="First Name" name="first_name" value="<?= @$first_name ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="<?= @$last_name ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-3">
                        <select name="user_status" class="form-control form-select" style="font-size:13px;">
                            <option value="" style="text-align:center">-User Status-</option>
                            <option value="Active" <?php if (@$user_status == 'Active') { ?> selected <?php } ?>>Active</option>
                            <option value="Inactive" <?php if (@$user_status == 'Inactive') { ?> selected <?php } ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="Contact Number" name="contact_number" value="<?= @$contact_number ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="Email" name="email" value="<?= @$email ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="NIC" name="nic" value="<?= @$nic ?>" style="font-size:13px;">
                    </div>
                    <div class="mb-3 col-md-3">
                        <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= SYSTEM_PATH ?>customer/customer.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-sm" style="font-size:13px;vertical-align: middle">
                    <thead class="bg-secondary" style="text-align:center;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Customer No</th>
                            <th scope="col">Name</th>
                            <th scope="col">NIC</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                            <th scope="col">User Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM customer c LEFT JOIN district d ON d.district_id=c.district_id "
                                . "LEFT JOIN user u ON u.user_id=c.user_id "
                                . "$where ORDER BY c.customer_id ASC";
                        //print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['customer_no'] ?></td>
                                    <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
                                    <td><?= $row['nic'] ?></td>
                                    <td><?= $row['contact_number'] . "<br>" . $row['alternate_number'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['house_no'] . ",<br>" . $row['street'] . ",<br>" . $row['city'] . ",<br>" . $row['district_name'] ?></td>
                                    <td><?= $row['user_status'] ?></td>
                                    <td style="text-align:center;"><a href="view.php?customer_id=<?= $row['customer_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
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
