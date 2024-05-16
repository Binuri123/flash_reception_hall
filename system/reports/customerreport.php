<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>reports/reportmenu.php">Reports</a></li>
                <li class="breadcrumb-item active" aria-current="page">Customer Report</li>
            </ol>
        </nav>
    </div>
    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
        // 3rd step- clean input
        $regno = cleanInput($regno);
        $cusname = cleanInput($cusname);
        $nic = cleanInput($nic);
        $contact = cleanInput($contact);
        $email = cleanInput($email);
        if (!empty($regno)) {
            $where .= " customer_no LIKE '%$regno%' AND";
        }
        if (!empty($cusname)) {
            $where .= " first_name LIKE '%$cusname%' OR last_name LIKE '%$cusname%' AND";
        }
        if (!empty($nic)) {
            $where .= " nic LIKE '%$nic%' AND";
        }
        if (!empty($contact)) {
            $where .= " contact_number LIKE '%$contact%' AND";
        }
        if (!empty($email)) {
            $where .= " email LIKE '%$email%' AND";
        }
        if (!empty($regdatestart) && !empty($regdateend)) {
            $where .= " add_date BETWEEN '$regdatestart' AND '$regdateend' AND";
        }
        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = "WHERE $where";
        }

        $sql2 = "SELECT * FROM customer c LEFT JOIN customer_titles t ON t.title_id=c.title_id $where ";
        $db = dbConn();
        $result2 = $db->query($sql2);
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
        <div class="row mb-3">
            <div class="col">
                <input type="text" class="form-control" placeholder="RegNo" name="regno" style="font-size:13px;">
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Name" name="cusname" style="font-size:13px;">
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="NIC" name="nic" style="font-size:13px;">
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Contact No" name="contact" style="font-size:13px;">
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Email" name="email" style="font-size:13px;">
            </div>
            <div class="col">
                <input type="date" class="form-control" placeholder="Reg Date" name="regdatestart" style="font-size:13px;">
            </div>
            <div class="col">
                <input type="date" class="form-control" placeholder="Reg Date" name="regdateend" style="font-size:13px;">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-warning btn-sm" style="font-size:13px;"><i class="bi bi-search"> Search</i></button>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Reg No</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">NIC</th>
                    <th scope="col">Contact No</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Registered Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    if ($result2->num_rows > 0) {
                        while ($row = $result2->fetch_assoc()) {
                            ?>
                            <tr>
                                <td></td>
                                <td><?= $row['customer_no'] ?></td>
                                <td><?= $row['title_name'] . " " . $row['first_name'] . " " . $row['last_name'] ?></td>
                                <td><?= $row['nic'] ?></td>
                                <td><?= $row['contact_number'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['add_date'] ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php include '../footer.php'; ?> 