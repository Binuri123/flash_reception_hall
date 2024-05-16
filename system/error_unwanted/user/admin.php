<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-10">
            <h3 class="h3">Dashboard</h3>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-2">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <?php
                    $db = dbConn();
                    $year = date('Y');
                    $sql = "SELECT count(*) as total_customers FROM customer WHERE YEAR(add_date) = '$year'";
                    $result = $db->query($sql);
                    $row = $result->fetch_assoc();
                    $total_customers = $row['total_customers'];
                    ?>
                    <h6># Customers<br>(<?= $year ?>)<br><?= $total_customers ?></h6>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <?php
                    $db = dbConn();
                    $year = date('Y');
                    $sql = "SELECT count(*) as total_annual_reservations FROM reservation WHERE YEAR(event_date) = '$year'";
                    $result = $db->query($sql);
                    $row = $result->fetch_assoc();
                    $total_annual_reservations = $row['total_annual_reservations'];
                    ?>
                    <h6># Reservations<br>(<?= $year ?>)<br><?= $total_annual_reservations ?></h6>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <?php
                    $db = dbConn();
                    $year = date('Y');
                    $sql_income = "SELECT SUM(paid_amount) as total_income FROM customer_payments WHERE YEAR(verified_date) = '$year'";
                    $result_income = $db->query($sql_income);
                    $row_income = $result_income->fetch_assoc();
                    $total_income = $row_income['total_income'];
                    ?>
                    <h6>Income<br>(<?= $year ?>)<br><?= $total_income ?></h6>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <?php
                    $db = dbConn();
                    $year = date('Y');
                    $month = date('m');
                    $month_name = date('M');
                    //var_dump($month);
                    $sql = "SELECT count(*) as total_monthly_reservations FROM reservation WHERE MONTH(event_date) = '$month'";
                    $result = $db->query($sql);
                    $row = $result->fetch_assoc();
                    $total_monthly_reservations = $row['total_monthly_reservations'];
                    ?>
                    <h6># Expenses<br>(<?= $year ?>)<br><?= $total_monthly_reservations ?></h6>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <a href="<?= SYSTEM_PATH ?>reservation/reservation.php" style="text-decoration:none;color:white">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <?php
                        $db = dbConn();
                        $cDate = date('Y-m-d');
                        //var_dump($month);
                        $sql = "SELECT count(*) as total_daily_reservations FROM reservation WHERE event_date = '$cDate'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        $total_daily_reservations = $row['total_daily_reservations'];
                        ?>
                        <h5># Reservations (Today)<br><?= $total_daily_reservations ?></h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <a href="<?= SYSTEM_PATH ?>customer_payments/customer_payment.php" style="text-decoration:none;color:white">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <?php
                        $db = dbConn();
                        $year = date('Y');
                        $sql = "SELECT count(*) as total_annual_reservations FROM reservation WHERE YEAR(event_date) = '$year'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        $total_annual_reservations = $row['total_annual_reservations'];
                        ?>
                        <h5># Income (<?= $year ?>)<br><?= $total_annual_reservations ?></h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="<?= SYSTEM_PATH ?>customer_payments/customer_payment.php" style="text-decoration:none;color:white">
                <div class="card bg-secondary text-white">
                    <div class="card-body text-center">

                        <?php
                        $db = dbConn();
                        $month = date('m');
                        $month_name = date('M');
                        //var_dump($month);
                        $sql = "SELECT count(*) as total_monthly_reservations FROM reservation WHERE MONTH(event_date) = '$month'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        $total_monthly_reservations = $row['total_monthly_reservations'];
                        ?>
                        <h5># Expenses (<?= $month_name ?>)<br><?= $total_monthly_reservations ?></h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="<?= SYSTEM_PATH ?>customer_payments/customer_payment.php" style="text-decoration:none;color:white">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <?php
                        $db = dbConn();
                        $cDate = date('Y-m-d');
                        //var_dump($month);
                        $sql = "SELECT count(*) as total_daily_reservations FROM reservation WHERE event_date = '$cDate'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();
                        $total_daily_reservations = $row['total_daily_reservations'];
                        ?>
                        <h5># Profit (Today)<br><?= $total_daily_reservations ?></h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3"></div>
    </div>
</main>