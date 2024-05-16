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
                    <li class="breadcrumb-item active">Unsuccessful Payments</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <?php
        $where = null;
        extract($_POST);
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'search') {
            $reservation_no = cleanInput($reservation_no);

            if (!empty($receipt_no)) {
                $where .= " p.receipt_no LIKE '%$receipt_no%' AND";
            }

            if (!empty($reservation_no)) {
                $where .= " p.reservation_no LIKE '%$reservation_no%' AND";
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
                    <div class="col-md-2 mb-3">
                        <input type="text" name="receipt_no" value="<?= @$receipt_no ?>" placeholder="Receipt No" style="font-size:10px;" class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="text" name="reservation_no" value="<?= @$reservation_no ?>" placeholder="Reservation No" style="font-size:10px;" class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM payment_category";
                        $result = $db->query($sql);
                        ?>
                        <select name="payment_category" class="form-control form-select" style="font-size:10px;">
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
                    <div class="col-md-2 mb-3">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM payment_method";
                        $result = $db->query($sql);
                        ?>
                        <select name="payment_method" class="form-control form-select" style="font-size:10px;">
                            <option value="" style="text-align:center">-Method-</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['method_id'] ?>" <?php if ($row['method_id'] == @$payment_method) { ?> selected <?php } ?>><?= $row['method_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:10px;width:70px;"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= WEB_PATH ?>payment/unsuccessful_payments.php" class="btn btn-info btn-sm" style="font-size:10px;width:70px;"><i class="bi bi-eraser"></i> Clear</a>
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
                                <th>Receipt No</th>
                                <th>Reservation No</th>
                                <th>Total Amount</th>
                                <th>Payment</th>
                                <th>Paid Amount</th>
                                <th>Paid Date</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT p.receipt_no,p.reservation_no,r.discounted_price,pc.payment_category_name,"
                                    . "p.paid_amount,p.paid_date,pm.method_name,ps.status_name,p.verified_date FROM customer_payments p "
                                    . "LEFT JOIN reservation r ON r.reservation_no=p.reservation_no "
                                    . "LEFT JOIN payment_category pc ON pc.payment_category_id=p.payment_category_id "
                                    . "LEFT JOIN payment_method pm ON pm.method_id=p.payment_method_id "
                                    . "LEFT JOIN payment_status ps ON ps.payment_status_id=p.payment_status "
                                    . "WHERE p.customer_no=(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ") AND p.payment_status='3'";
                            //print_r($sql);
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $i = 1;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr style="font-size:13px;vertical-align:middle">
                                        <td><?= $i ?></td>
                                        <td><?= $row['receipt_no'] ?></td>
                                        <td><?= $row['reservation_no'] ?></td>
                                        <td><?= $row['discounted_price'] ?></td>
                                        <td><?= $row['payment_category_name'] ?></td>
                                        <td><?= $row['paid_amount'] ?></td>
                                        <td><?= $row['paid_date'] ?></td>
                                        <td><?= $row['method_name'] ?></td>
                                        <td><?= $row['status_name'] ?></td>
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