<?php
ob_start();
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>customer_payment/customer_payment.php">Customer Payments</a></li>
                <li class="breadcrumb-item active" aria-current="page">View</li>
            </ol>
        </nav>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
        $payment_id = $_GET['payment_id'];
        $db = dbConn();
        $sql = "SELECT * FROM customer_payments WHERE payment_id='$payment_id'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        //var_dump($row);
    }
    ?>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered border-secondary">
                                    <thead class="bg-secondary-light border-dark text-center">
                                        <tr>
                                            <th colspan="2">Payment Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>Receipt No</td>
                                            <td><?= $row['receipt_no'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Reservation No</td>
                                            <td><?= $row['reservation_no'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Customer No</td>
                                            <td><?= $row['customer_no'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Reservation Price (Rs.)</td>
                                            <td><?= number_format($row['reservation_price'], '2', '.', ',') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Payment Category</td>
                                            <?php
                                            $db = dbConn();
                                            $sql_pay_category = "SELECT payment_category_name FROM payment_category WHERE payment_category_id=" . $row['payment_category_id'];
                                            $result_pay_category = $db->query($sql_pay_category);
                                            $row_pay_category = $result_pay_category->fetch_assoc();
                                            $pay_category = $row_pay_category['payment_category_name'];
                                            ?>
                                            <td><?= @$pay_category ?></td>
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
                                            $db = dbConn();
                                            $sql_pay_method = "SELECT method_name FROM payment_method WHERE method_id=" . $row['payment_method_id'];
                                            $result_pay_method = $db->query($sql_pay_method);
                                            $row_pay_method = $result_pay_method->fetch_assoc();
                                            $pay_method = $row_pay_category['payment_category_name'];
                                            ?>
                                            <td><?= $pay_method ?></td>
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
                        <div class="col-md-6">
                            <a href="../../web/assets/img/pay_slip/customer/<?= $row['pay_slip'] ?>"><img src="../../web/assets/img/pay_slip/customer/<?= $row['pay_slip'] ?>" style="width:350px;height:350px;"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</main>
<?php
ob_end_flush();
include '../footer.php';
?>