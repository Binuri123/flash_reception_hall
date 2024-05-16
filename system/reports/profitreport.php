<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>reports/reportmenu.php">Reports</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profit Report</li>
            </ol>
        </nav>
    </div>
    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
        if (!empty($resdatestart) && !empty($resdateend)) {
            $where .= " paid_date BETWEEN '$resdatestart' AND '$resdateend' AND rp.issued_date BETWEEN '$resdatestart' AND '$resdateend' AND ";
        }
        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = "WHERE $where";
        }
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
        <div class="row mt-3">
            <div class="col-md-3">
                <input type="date" class="form-control" placeholder="Date" name="resdatestart" style="font-size:13px;">
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" placeholder="Date" name="resdateend" style="font-size:13px;">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"> Search</i></button>
            </div>
        </div>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $db = dbConn();
        $sql = "SELECT SUM(paid_amount) FROM customer_payments WHERE payment_status=2 AND paid_date BETWEEN '$resdatestart' AND '$resdateend'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $income = $row['SUM(paid_amount)'];
        }
        $db = dbConn();
        $sql = "SELECT SUM(rp.refundable_amount) FROM refund_request rp WHERE rp.refund_status_id=5 AND rp.issued_date BETWEEN '$resdatestart' AND '$resdateend' ";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $expenses = $row['SUM(rp.refundable_amount)'];
        }
        $profit = $income - $expenses;
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-striped table-sm" style="font-size:13px;">
                        <tbody>
                            <tr>
                                <td><h4>Total Income</h4></td>
                                <td  style="text-align: right"><h4><?= number_format($income,2) ?></h4></td>
                            </tr>
                            <tr>
                                <td><h4>Total Expenses</h4></td>
                                <td  style="text-align: right"><h4><?= number_format($expenses,2) ?></h4></td>
                            </tr>
                            <tr>
                                <td><h4>Total Profit</h4></td>
                                <td  style="text-align: right"><h4><?= number_format($profit,2) ?></h4></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</main>
<?php include '../footer.php'; ?> 