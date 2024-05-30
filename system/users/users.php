<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="pagetitle mt-4">
        <h1>Users</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="<?= SYSTEM_PATH ?>employee/employee.php" style="text-decoration:none;color:white">
                    <div class="card bg-success text-success" style="--bs-bg-opacity: .1;">
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
            <div class="col">
                <a href="<?= SYSTEM_PATH ?>customer/customer.php" style="text-decoration:none;color:white">
                    <div class="card bg-secondary text-secondary" style="--bs-bg-opacity:.1;">
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
            <div class="col"></div>
            <div class="col"></div>
        </div>
    </div>
</main>
<?php include '../footer.php'; ?>
