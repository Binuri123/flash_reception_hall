<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <?php
            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '6' || $_SESSION['user_role_id'] == '4') {
                ?>
                <div class="col-md-3">
                    <a href="<?= SYSTEM_PATH ?>employee/employee.php" style="text-decoration:none;color:white">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT count(*) as total_employees FROM employee";
                                $result = $db->query($sql);
                                $row = $result->fetch_assoc();
                                $employee_count = $row['total_employees'];
                                ?>
                                <h4># Employees<br><?= $employee_count ?></h4>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>customer/customer.php" style="text-decoration:none;color:white">
                    <div class="card bg-secondary text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as total_customers FROM customer";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $customers_count = $row['total_customers'];
                            ?>
                            <h4># Customers<br><?= $customers_count ?></h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>

<?php include '../footer.php'; ?>
