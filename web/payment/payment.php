<?php
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main">
    <section>
        <div class="pagetitle">
            <div class="row">
                <div class="col-md-6">
                    <h1>Payments</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payments</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6" style="text-align:right">
                    <a href="<?= WEB_PATH ?>payment/pending_payments.php" class="btn btn-info-light btn-outline-success btn-sm" style="font-size:13px;"><i class="bi bi-plus-circle"></i> Make Payment</a>
                </div>
            </div>
        </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>payment/pending_payments.php">
                    <div class="card bg-warning text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as pending_payments FROM reservation r "
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
                                    . "OR (r.reservation_status_id = '2' AND r.reservation_payment_status_id = '6' AND p.payment_status = '3'))";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $pending_payments = $row['pending_payments']
                            ?>
                            <h5># Pending<br><?= @$pending_payments ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>payment/verified_payments.php">
                    <div class="card bg-success text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as verified_payments FROM customer_payments WHERE customer_no =(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ") AND (payment_status='2' OR payment_status='4')";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $verified_payments = $row['verified_payments']
                            ?>
                            <h5># Verified<br><?= @$verified_payments ?></h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <a href="<?= WEB_PATH ?>payment/unsuccessful_payments.php">
                    <div class="card bg-danger text-white">
                        <div class="card-body mt-4" style="text-align:center;vertical-align:middle">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT COUNT(*) as unsuccessful_payments FROM customer_payments "
                                    . "WHERE customer_no =(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ") AND payment_status='3'";
                            //print_r($sql);
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $unsuccessful_payments = $row['unsuccessful_payments']
                            ?>
                            <h5># Unsuccessful<br><?= @$unsuccessful_payments ?></h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
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
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM payment_status WHERE payment_status_id != '5'";
                            $result = $db->query($sql);
                            ?>
                            <select name="payment_status" class="form-control form-select" style="font-size:10px;">
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
                        <div class="col-md-2 mb-3">
                            <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:10px;width:70px;"><i class="bi bi-search"></i> Search</button>
                            <a href="<?= WEB_PATH ?>payment/payment.php" class="btn btn-info btn-sm" style="font-size:10px;width:70px;"><i class="bi bi-eraser"></i> Clear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped bg-light" style="font-size:13px;">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th style="text-align:center">#</th>
                                <th style="text-align:center">Receipt No</th>
                                <th style="text-align:center">Reservation No</th>
                                <th style="text-align:right">Total Amount (Rs.)</th>
                                <th style="text-align:center">Payment</th>
                                <th style="text-align:right">Paid Amount (Rs.)</th>
                                <th style="text-align:center">Paid Date</th>
                                <th style="text-align:center">Payment Method</th>
                                <th style="text-align:center">Payment Status</th>
                                <th style="text-align:center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT p.receipt_no,p.reservation_no,r.discounted_price,pc.payment_category_name,"
                                    . "p.paid_amount,p.paid_date,pm.method_name,ps.status_name FROM customer_payments p "
                                    . "LEFT JOIN reservation r ON r.reservation_no=p.reservation_no "
                                    . "LEFT JOIN payment_category pc ON pc.payment_category_id=p.payment_category_id "
                                    . "LEFT JOIN payment_method pm ON pm.method_id=p.payment_method_id "
                                    . "LEFT JOIN payment_status ps ON ps.payment_status_id=p.payment_status "
                                    . "WHERE p.customer_no=(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ") $where";
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
                                        <td style="text-align:right"><?= number_format($row['discounted_price'], '2', '.', ',') ?></td>
                                        <td><?= $row['payment_category_name'] ?></td>
                                        <td style="text-align:right"><?= number_format($row['paid_amount'], '2', '.', ',') ?></td>
                                        <td><?= $row['paid_date'] ?></td>
                                        <td><?= $row['method_name'] ?></td>
                                        <td><?= $row['status_name'] ?></td>
                                        <td>
                                            <a href="<?= WEB_PATH ?>payment/view.php?receipt_no=<?= $row['receipt_no'] ?>" class="btn btn-info btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-eye-fill"></i></a>
                                        </td>
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