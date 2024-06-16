<?php
ob_start();
include '../header.php';
include '../menu.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="mt-3 pagetitle">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <h1 class="h4 m-0">Customer Payments</h1>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>customer_payment/customer_payment.php">Customer Payment</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>customer_payment/add.php">Make a Payment</a></li>
                <li class="breadcrumb-item active">Payment Success</li>
            </ol>
        </nav>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
        $db = dbConn();
//        $sql = "SELECT * FROM customer_payments p "
//                . "LEFT JOIN payment_category pc ON pc.payment_category_id=p.payment_category_id "
//                . "LEFT JOIN payment_method pm ON pm.method_id=p.payment_method_id "
//                . "LEFT JOIN customer_payment_bank cb ON cb.payment_id=p.payment_id "
//                . "LEFT JOIN customer_payment_online co ON co.payment_id=p.payment_id WHERE p.payment_id = '$payment_id'";
        $sql = "SELECT * FROM customer_payments WHERE payment_id = '$payment_id'";
        //print_r($sql);
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
    }
    ?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card bg-success-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mt-3 mb-3" style="text-align:center;">
                            <h4>Payment Successfully Made...!!!</h4>
                        </div>
                    </div>
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
                                            <td>Total Amount (Rs.)<br>(With Security Fee)</td>
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
                                        <?php
                                        if ($row['payment_method_id'] == '2') {
                                            ?>
                                            <tr>
                                                <td>Paid Bank</td>
                                                <?php
                                                $sql_bank_name = "SELECT b.bank_name,cb.bank_branch FROM bank_details b LEFT JOIN customer_payment_bank cb ON cb.bank_id=b.bank_detail_id WHERE cb.payment_id='$payment_id'";
                                                $result_bank_name = $db->query($sql_bank_name);
                                                $row_bank_name = $result_bank_name->fetch_assoc();
                                                ?>
                                                <td><?= $row_bank_name['bank_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Bank Branch</td>
                                                <td><?= $row_bank_name['bank_branch'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($row['payment_method_id'] == '3') {
                                            ?>
                                            <tr>
                                                <td>Paid Bank</td>
                                                <?php
                                                $sql_bank_name = "SELECT b.bank_name,co.reference_no FROM bank_details b LEFT JOIN customer_payment_online co ON co.bank_id=b.bank_detail_id WHERE co.payment_id='$payment_id'";
                                                //print_r($sql_bank_name);
                                                $result_bank_name = $db->query($sql_bank_name);
                                                $row_bank_name = $result_bank_name->fetch_assoc();
                                                ?>
                                                <td><?= $row_bank_name['bank_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Reference No</td>
                                                <td><?= $row_bank_name['reference_no'] ?></td>
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
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <p style="font-size:13px;"><strong><i>Your Payment Has Successfully Placed. Payment Verification In Progress.Please Wait for the Status Change</i></strong></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="font-size:13px;"><strong><i>Back to <a href="<?= SYSTEM_PATH ?>customer_payment/customer_payment.php" style="text-decoration:underline"> Payment History</a></i></strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <?php include '../footer.php'; ?>