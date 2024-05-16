<?php
ob_start();
include '../customer/header.php';
include '../customer/sidebar.php';
?>

<main id="main" class="main">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
        $db = dbConn();
//        $sql = "SELECT * FROM customer_payments p "
//                . "LEFT JOIN payment_category pc ON pc.payment_category_id=p.payment_category_id "
//                . "LEFT JOIN payment_method pm ON pm.method_id=p.payment_method_id "
//                . "LEFT JOIN customer_payment_bank cb ON cb.payment_id=p.payment_id "
//                . "LEFT JOIN customer_payment_online co ON co.payment_id=p.payment_id WHERE p.payment_id = '$payment_id'";
        $sql = "SELECT * FROM customer_payments WHERE receipt_no = '$receipt_no'";
        //print_r($sql);
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $payment_id = $row['payment_id'];
    }
    ?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="pagetitle">
                <h1>Payments</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>payment/payment.php">Payment</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 mt-3 mb-3" style="text-align:center;">
                            <div class="table-responsive">
                                <table class="table table-striped table-success table-bordered" style="font-size:13px;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Payment Details</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align:left;">
                                        <tr>
                                            <td>Receipt No</td>
                                            <td><?= $row['receipt_no'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Reservation No</td>
                                            <td><?= $row['reservation_no'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Reservation Price (Rs.)</td>
                                            <td><?= number_format($row['reservation_price'], '2', '.', ',') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Amount (With Security Fee) (Rs.)</td>
                                            <td><?= number_format($row['total_price'], '2', '.', ',') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Payment Category</td>
                                            <?php
                                            $sql_payment_category = "SELECT payment_category_name FROM payment_category WHERE payment_category_id=" . $row['payment_category_id'];
                                            $result_payment_category = $db->query($sql_payment_category);
                                            $row_payment_category = $result_payment_category->fetch_assoc();
                                            ?>
                                            <td><?= $row_payment_category['payment_category_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Paid Amount (Rs.)</td>
                                            <td><?= number_format($row['paid_amount'], '2', '.', ',') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Paid Date</td>
                                            <td><?= $row['paid_date'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Payment Method</td>
                                            <?php
                                            $sql_payment_method = "SELECT method_name FROM payment_method WHERE method_id=" . $row['payment_method_id'];
                                            $result_payment_method = $db->query($sql_payment_method);
                                            $row_payment_method = $result_payment_method->fetch_assoc();
                                            ?>
                                            <td><?= $row_payment_method['method_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Paid Bank</td>
                                            <?php
                                            $sql_bank_name = "SELECT b.bank_name FROM customer_payments p "
                                                    . "LEFT JOIN bank_details b ON p.bank_id=b.bank_detail_id WHERE p.payment_id='$payment_id'";
                                            $result_bank_name = $db->query($sql_bank_name);
                                            $row_bank_name = $result_bank_name->fetch_assoc();
                                            ?>
                                            <td><?= $row_bank_name['bank_name'] ?></td>
                                        </tr>
                                        <?php
                                        if ($row['payment_method_id'] == '2') {
                                            $sql_branch = "SELECT cb.bank_branch FROM customer_payments p "
                                                    . "LEFT JOIN customer_payment_bank cb ON p.payment_id=cb.payment_id WHERE p.payment_id='$payment_id'";
                                            $result_branch = $db->query($sql_branch);
                                            $row_branch = $result_branch->fetch_assoc();
                                            ?>
                                            <tr>
                                                <td>Bank Branch</td>
                                                <td><?= $row_branch['bank_branch'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($row['payment_method_id'] == '3') {
                                            ?>
                                            <tr>
                                                <?php
                                                $sql_ref_no = "SELECT co.reference_no FROM customer_payments p "
                                                        . "LEFT JOIN customer_payment_online co ON co.payment_id=p.payment_id WHERE p.payment_id='$payment_id'";
                                                //print_r($sql_bank_name);
                                                $result_ref_no = $db->query($sql_ref_no);
                                                $row_ref_no = $result_ref_no->fetch_assoc();
                                                ?>
                                                <td>Reference No</td>
                                                <td><?= $row_ref_no['reference_no'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td>Balance to Pay (Rs.)</td>
                                            <td><?= number_format($row['balance_amount'], '2', '.', ',') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Payment Status</td>
                                            <?php
                                            $sql_payment_status = "SELECT status_name FROM payment_status WHERE payment_status_id=" . $row['payment_status'];
                                            $result_payment_status = $db->query($sql_payment_status);
                                            $row_payment_status = $result_payment_status->fetch_assoc();
                                            ?>
                                            <td><?= $row_payment_status['status_name'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>