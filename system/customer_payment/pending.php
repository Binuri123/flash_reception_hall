<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>customer_payment/customer_payment.php">Customer Payment</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pending</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Pending Payments List</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped bg-light" style="font-size:13px;">
                    <thead style="text-align:center;vertical-align:middle;" class="bg-secondary">
                        <tr>
                            <th>#</th>
                            <th>Reservation No</th>
                            <th>Event Date</th>
                            <th>Reservation<br>Payment Status</th>
                            <th>Total<br>Amount (Rs.)</th>
                            <th>PaymentMade (Rs.)</th>
                            <th>Last<br>Payment Date</th>
                            <th>Payment Status</th>
                            <th>Balance<br>to be Paid(Rs.)</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '4') {
                                ?>
                                <th></th>
                                <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $db = dbConn();
                        $sql = "SELECT r.reservation_no,r.event_date,rps.payment_status,r.discounted_price,"
                                . "ps.status_name,p.payment_status as paid_status,p.receipt_no,p.payment_method_id FROM reservation r "
                                . "LEFT JOIN reservation_payment_status rps ON rps.payment_status_id = r.reservation_payment_status_id "
                                . "LEFT JOIN customer_payments p ON p.reservation_no=r.reservation_no "
                                . "LEFT JOIN payment_status ps ON ps.payment_status_id = p.payment_status "
                                . "WHERE r.reservation_no NOT IN (SELECT reservation_no FROM customer_payments) "
                                . "OR (p.payment_category_id='1' AND p.payment_method_id='1' AND p.payment_status = '1') "
                                . "OR (p.payment_category_id='1' AND p.payment_method_id='1' AND p.payment_status = '2') "
                                . "OR (p.payment_category_id='1' AND p.payment_method_id='2' AND p.payment_status = '2') "
                                . "OR (p.payment_category_id='1' AND p.payment_method_id='3' AND p.payment_status = '2') "
                                . "OR (p.payment_category_id='2' AND p.payment_method_id='1' AND p.payment_status = '1') "
                                . "OR (p.payment_category_id='2' AND p.payment_method_id='1' AND p.payment_status = '2') "
                                . "OR (p.payment_category_id='2' AND p.payment_method_id='2' AND p.payment_status = '2') "
                                . "OR (p.payment_category_id='2' AND p.payment_method_id='3' AND p.payment_status = '2') "
                                . "OR (p.payment_category_id='1' AND p.payment_method_id='1' AND p.payment_status = '3') "
                                . "OR (p.payment_category_id='1' AND p.payment_method_id='2' AND p.payment_status = '3') "
                                . "OR (p.payment_category_id='1' AND p.payment_method_id='3' AND p.payment_status = '3') "
                                . "OR (p.payment_category_id='2' AND p.payment_method_id='1' AND p.payment_status = '3') "
                                . "OR (p.payment_category_id='2' AND p.payment_method_id='2' AND p.payment_status = '3') "
                                . "OR (p.payment_category_id='2' AND p.payment_method_id='3' AND p.payment_status = '3') "
                                . "OR (p.payment_category_id='3' AND p.payment_method_id='1' AND p.payment_status = '1') "
                                . "OR (p.payment_category_id='3' AND p.payment_method_id='1' AND p.payment_status = '3') "
                                . "OR (p.payment_category_id='3' AND p.payment_method_id='2' AND p.payment_status = '3') "
                                . "OR (p.payment_category_id='3' AND p.payment_method_id='3' AND p.payment_status = '3') "
                                . "OR (p.payment_category_id='4' AND p.payment_method_id='1' AND p.payment_status = '1') "
                                . "OR (p.payment_category_id='4' AND p.payment_method_id='1' AND p.payment_status = '3') "
                                . "OR (p.payment_category_id='4' AND p.payment_method_id='2' AND p.payment_status = '3') "
                                . "OR (p.payment_category_id='4' AND p.payment_method_id='3' AND p.payment_status = '3') ";
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
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '4') {
                                        if ($row['paid_status'] == NULL || $row['paid_status'] == '2') {
                                            ?>
                                            <td>
                                                <a href="<?= SYSTEM_PATH ?>customer_payment/add.php?reservation_no=<?= $row['reservation_no'] ?>" class="btn btn-success btn-sm" style="font-size:13px;text-align:center;vertical-align:middle;width:108px;">Make Payment</a>
                                            </td>
                                            <?php
                                        } elseif ($row['payment_method_id'] == '1' && ($row['paid_status'] == '1' || $row['paid_status'] == '3')) {
                                            ?>
                                            <td>
                                                <a href="<?= SYSTEM_PATH ?>customer_payment/edit.php?receipt_no=<?= $row['receipt_no'] ?>" class="btn btn-warning btn-sm" style="font-size:13px;text-align:center;vertical-align:middle;width:108px;">Edit Payment</a>
                                            </td>
                                            <?php
                                        } else {
                                            ?>
                                            <td></td>
                                            <?php
                                        }
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
<?php include('../footer.php') ?>