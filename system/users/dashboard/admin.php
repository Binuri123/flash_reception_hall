<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php require_once __DIR__.'/dashboard_banner.php'; ?>
    <div class="row mb-3">
        <div class="col-md-2">
            <div class="card bg-info text-info"  style="--bs-bg-opacity: .05;">
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
            <div class="card bg-warning text-warning" style="--bs-bg-opacity: .05;">
                <div class="card-body text-center">
                    <?php
                    $db = dbConn();
                    $year = date('Y');
                    $sql = "SELECT count(*) as total_annual_reservations FROM reservation WHERE YEAR(event_date) = '$year' AND reservation_status_id='5'";
                    $result = $db->query($sql);
                    $row = $result->fetch_assoc();
                    $total_annual_reservations = $row['total_annual_reservations'];
                    ?>
                    <h6># Reservations<br>(<?= $year ?>)<br><?= $total_annual_reservations ?></h6>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-success" style="--bs-bg-opacity: .05;" >
                <div class="card-body text-center">
                    <?php
                    $db = dbConn();
                    $year = date('Y');
                    $sql_income = "SELECT SUM(paid_amount) as total_income FROM customer_payments WHERE YEAR(verified_date) = '$year'";
                    $result_income = $db->query($sql_income);
                    $row_income = $result_income->fetch_assoc();
                    $total_income = $row_income['total_income'];
                    ?>
                    <h6>Income (LKR)<br>(<?= $year ?>)<br><?= number_format($total_income, '2', '.', ',') ?></h6>
                </div>
            </div>
        </div>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '3' || $_SESSION['user_role_id'] == '4' || $_SESSION['user_role_id'] == '6') {
            ?>
            <div class="col-md-2">
                <div class="card bg-primary text-primary" style="--bs-bg-opacity: .1;">
                    <div class="card-body text-center">
                        <?php
                        $db = dbConn();
                        $year = date('Y');
                        $sql_expense = "SELECT SUM(refundable_amount) as total_expense FROM refund_request WHERE YEAR(issued_date) = '$year'";
                        $result_expense = $db->query($sql_expense);
                        $row_expense = $result_expense->fetch_assoc();
                        $total_expense = $row_expense['total_expense'];
                        ?>
                        <h6># Expenses (LKR)<br>(<?= $year ?>)<br><?= number_format($total_expense, '2', '.', ',') ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-danger text-danger"  style="--bs-bg-opacity: .1;">
                    <div class="card-body text-center">
                        <?php
                        if($total_income == 0){
                            $profit = 0;
                        }else{
                            $profit = ($total_income - $total_expense) * 100 / $total_income;
                        }
                        ?>
                        <h6># Profit<br>(<?= $year ?>)<br><?= $profit . "%" ?></h6>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="col-md-2"></div>
    </div>
</main>