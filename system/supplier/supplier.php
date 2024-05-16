<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Supplier</li>
            </ol>
        </nav>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '3' || $_SESSION['user_role_id'] == '6') {
            ?>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>supplier/add.php"><i class="bi bi-plus-circle"></i> New Supplier</a>
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
        $supplier_no = cleanInput($supplier_no);
        $first_name = cleanInput($first_name);
        $last_name = cleanInput($last_name);
        $contact_number = cleanInput($contact_number);
        $email = cleanInput($email);
        $nic = cleanInput($nic);

        if (!empty($supplier_no)) {
            //Wild card serach perform using like and %% signs
            $where .= " s.supplier_no LIKE '%$supplier_no%' AND";
        }
        if (!empty($first_name)) {
            //Wild card serach perform using like and %% signs
            $where .= " s.first_name LIKE '%$first_name%' AND";
        }
        if (!empty($last_name)) {
            //Wild card serach perform using like and %% signs
            $where .= " s.last_name LIKE '%$last_name%' AND";
        }
        if (!empty($designation)) {
            //Exact Search perform using = sign
            $where .= " s.designation_id ='$designation' AND";
        }
        if (!empty($contact_number)) {
            $where .= " (s.contact_number LIKE '%$contact_number%' OR s.alternate_number LIKE '%$contact_number%') AND";
        }
        if (!empty($email)) {
            $where .= " s.email LIKE '%$email%' AND";
        }
        if (!empty($nic)) {
            $where .= " s.nic LIKE '%$nic%' AND";
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " WHERE $where";
        }
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <h3>Supplier List</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Supplier No" name="supplier_no" value="<?= @$supplier_no ?>" style="font-size:13px;">
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
                    <div class="mb-3 col-md-3">
                        <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= SYSTEM_PATH ?>supplier/supplier.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
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
                        <tr style="text-align:center;">
                            <th>#</th>
                            <th scope="col">Supplier No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Contact No</th>
                            <th scope="col">Email</th>
                            <th scope="col">NIC</th>
                            <th scope="col">Agreement Start Date</th>
                            <th scope="col">Agreement End Date</th>
                            <th scope="col">Agreement Status</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '3' || $_SESSION['user_role_id'] == '6') {
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
                        $sql = "SELECT * FROM supplier s "
                                . "LEFT JOIN agreement_status a ON a.agreement_status_id=s.agreement_status_id $where ORDER BY s.supplier_id ASC";
                        //print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td style="text-align:center;"><?= $row['supplier_no'] ?></td>
                                    <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
                                    <td style="text-align:center;"><?= $row['contact_number'] ?><br><?= $row['alternate_number'] ?></td>
                                    <td style="text-align:center;"><?= $row['email'] ?></td>
                                    <td style="text-align:center;"><?= $row['nic'] ?></td>
                                    <td style="text-align:center;"><?= $row['agreement_start_date'] ?></td>
                                    <td style="text-align:center;"><?= $row['agreement_end_date'] ?></td>
                                    <td style="text-align:center;"><?= $row['agreement_status'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '3' || $_SESSION['user_role_id'] == '6') {
                                        ?>
                                        <td><a href="<?= SYSTEM_PATH ?>supplier/edit.php?supplier_id=<?= $row['supplier_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a></td>
                                        <?php
                                    }
                                    ?>
                                    <td><a href="<?= SYSTEM_PATH ?>supplier/view.php?supplier_id=<?= $row['supplier_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
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
