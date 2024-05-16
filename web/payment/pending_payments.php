<?php
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main">
    <section>
        <div class="pagetitle">
            <h1>Payments</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>payment/payment.php">Payments</a></li>
                    <li class="breadcrumb-item active">Pending Payments</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <?php
        $where = null;
        extract($_POST);
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'search') {
            $reservation_no = cleanInput($reservation_no);

            if (!empty($reservation_no)) {
                $where .= " r.reservation_no LIKE '%$reservation_no%' AND";
            }

            if (!empty($payment_category)) {
                $where .= " p.payment_category_id = '$payment_category' AND";
            }

            if (!empty($payment_method)) {
                $where .= " p.payment_method_id = '$payment_method' AND";
            }

            if (!empty($payment_status)) {
                $where .= " p.payment_status = '$payment_status' AND";
            }

            if (!empty($where)) {
                $where = substr($where, 0, -3);
                $where = " AND $where";
            }
        }
        ?>
        <div class="col-md-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="text" name="reservation_no" value="<?= @$reservation_no ?>" placeholder="Reservation No" style="font-size:13px;" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM payment_category";
                        $result = $db->query($sql);
                        ?>
                        <select name="payment_category" class="form-control form-select" style="font-size:13px;">
                            <option value="" style="text-align:center">-Payment-</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['payment_category_id'] ?>" <?php if ($row['payment_category_id'] == @$payment_category) { ?> selected <?php } ?>><?= $row['payment_category_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM payment_status WHERE payment_status_id = '2' OR  payment_status_id = '3'";
                        $result = $db->query($sql);
                        ?>
                        <select name="payment_status" class="form-control form-select" style="font-size:13px;">
                            <option value="" style="text-align:center">-Status-</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['payment_status_id'] ?>" <?php if ($row['payment_status_id'] == @$payment_status) { ?> selected <?php } ?>><?= $row['status_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= WEB_PATH ?>payment/pending_payments.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped bg-light" style="font-size:13px;">
                        <thead style="font-size:13px;text-align:center;vertical-align:middle;" class="bg-secondary text-white">
                            <tr style="vertical-align:middle">
                                <th>#</th>
                                <th>Reservation No</th>
                                <th>Reservation Date</th>
                                <th>Reservation<br>Payment Status</th>
                                <th>Total<br>Amount (Rs.)</th>
                                <th>Payment Made (Rs.)</th>
                                <th>Last<br>Payment Date</th>
                                <th>Payment Status</th>
                                <th>Balance<br>to be Paid(Rs.)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT r.reservation_no,r.event_date,rps.payment_status,r.discounted_price,"
                                    . "ps.status_name,p.payment_status as paid_status,p.receipt_no FROM reservation r "
                                    . "LEFT JOIN reservation_payment_status rps ON rps.payment_status_id = r.reservation_payment_status_id "
                                    . "LEFT JOIN customer_payments p ON p.reservation_no=r.reservation_no "
                                    . "LEFT JOIN payment_status ps ON ps.payment_status_id = p.payment_status "
                                    . "WHERE r.customer_no =(SELECT customer_no FROM customer WHERE customer_id = " . $_SESSION['customer_id'] . ") "
                                    . "AND((r.reservation_status_id = '1' AND r.reservation_payment_status_id = '1') "
                                    . "OR (r.reservation_status_id = '1' AND r.reservation_payment_status_id = '1' AND p.payment_status = '1') "
                                    . "OR (r.reservation_status_id = '1' AND r.reservation_payment_status_id = '1' AND p.payment_status = '3') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '6' AND p.payment_status = '2') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '6' AND p.payment_status = '1') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '6' AND p.payment_status = '3') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '2' AND p.payment_status = '2') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '2' AND p.payment_status = '1') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '2' AND p.payment_status = '3') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '6' AND p.payment_status = '1') "
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '6' AND p.payment_status = '3')) $where";
                            //print_r($sql);
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $i = 1;
                                while ($row = $result->fetch_assoc()) {
                                    //var_dump($row);
                                    ?>
                                    <tr style="font-size:13px;vertical-align:middle">
                                        <td><?= $i ?></td>
                                        <td style="text-align:center;"><?= $row['reservation_no'] ?></td>
                                        <td><?= $row['event_date'] ?></td>
                                        <td style="text-align:center;"><?= $row['payment_status'] ?></td>
                                        <td style="text-align:right;">
                                            <?php
                                            $total_reservation_amount = $row['discounted_price'] + 40000.00;
                                            echo number_format($total_reservation_amount, '2', '.', ',');
                                            ?>
                                        </td>
                                        <td style="text-align:right;">
                                            <?php
                                            $sql_paid_amount = "SELECT SUM(paid_amount) AS total_paid FROM customer_payments WHERE reservation_no='" . $row['reservation_no'] . "'";
                                            $result_paid_amount = $db->query($sql_paid_amount);
                                            $row_paid_amount = $result_paid_amount->fetch_assoc();
                                            echo number_format($row_paid_amount['total_paid'], '2', '.', ',');
                                            ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php
                                            $last_pay_date = "SELECT MAX(paid_date) as last_payment_date FROM customer_payments WHERE reservation_no ='" . $row['reservation_no'] . "'";
                                            $result_pay_date = $db->query($last_pay_date);
                                            $row_pay_date = $result_pay_date->fetch_assoc();
                                            if ($row_pay_date['last_payment_date'] == NULL) {
                                                echo 'Not Yet Paid';
                                            } else {
                                                echo $row_pay_date['last_payment_date'];
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php
                                            if ($row['status_name'] == NULL) {
                                                echo 'Not Yet Paid';
                                            } else {
                                                echo $row['status_name'];
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align:right;">
                                            <?php
                                            $balance_amount = $total_reservation_amount - $row_paid_amount['total_paid'];
                                            echo number_format($balance_amount, '2', '.', ',');
                                            ?>
                                        </td>

                                        <?php
                                        if ($row['paid_status'] == NULL || $row['paid_status'] == '2') {
                                            ?>
                                            <td>
                                                <a href="<?= WEB_PATH ?>payment/add.php?reservation_no=<?= $row['reservation_no'] ?>" class="btn btn-success btn-sm" style="font-size:13px;text-align:center;vertical-align:middle;width:108px;">Make Payment</a>
                                            </td>
                                            <?php
                                        } elseif ($row['paid_status'] == '1' || $row['paid_status'] == '3') {
                                            ?>
                                            <td>
                                                <a href="<?= WEB_PATH ?>payment/edit.php?receipt_no=<?= $row['receipt_no'] ?>" class="btn btn-warning btn-sm" style="font-size:13px;text-align:center;vertical-align:middle;width:108px;">Edit Payment</a>
                                            </td>
                                            <?php
                                        }
                                        ?>
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
    </section>
</main>
<?php include('../customer/footer.php') ?>