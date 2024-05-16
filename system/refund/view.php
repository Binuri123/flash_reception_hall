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
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>refund/refund.php">Refunds</a></li>
                <li class="breadcrumb-item active" aria-current="page">View</li>
            </ol>
        </nav>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
        $db = dbConn();
        $sql = "SELECT * FROM refund_request WHERE reservation_no = '$reservation_no'";
        //print_r($sql);
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
    }
    ?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mt-3 mb-3" style="text-align:center;">
                            <h4>Request Successfully Sent...!!!</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 mt-3 mb-3" style="text-align:center;">
                            <div class="table-responsive">
                                <table class="table table-striped table-secondary table-bordered" style="font-size:13px;">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Request Details</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align:left;">
                                        <tr>
                                            <td>Reservation No</td>
                                            <td><?= $row['reservation_no'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Paid Amount (Rs.)</td>
                                            <td><?= number_format($row['paid_amount'], '2', '.', ',') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Refundable Amount (Rs.)</td>
                                            <td><?= number_format($row['refundable_amount'], '2', '.', ',') ?></td>
                                        </tr>
                                        <tr>
                                            <td>Expected Refund Method</td>
                                            <td>
                                                <?php
                                                $db = dbConn();
                                                $sql_refund_method = "SELECT method_name FROM payment_method WHERE method_id='" . $row['refund_method_id'] . "'";
                                                $result_refund_method = $db->query($sql_refund_method);
                                                $row_refund_method = $result_refund_method->fetch_assoc();
                                                echo $refund_method = $row_refund_method['method_name']
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        if ($row['refund_method_id'] == '1') {
                                            $sql_cash_refund = "SELECT cash_collector_name,cash_collector_nic FROM cash_refund WHERE refund_request_id='" . $row['refund_request_id'] . "'";
                                            //print_r($sql_bank_name);
                                            $result_cash_refund = $db->query($sql_cash_refund);
                                            $row_cash_refund = $result_cash_refund->fetch_assoc();
                                            ?>
                                            <tr>
                                                <td>Cash Collector's Name</td>
                                                <td><?= $row_cash_refund['cash_collector_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Cash Collector's NIC</td>
                                                <td><?= $row_cash_refund['cash_collector_nic'] ?></td>
                                            </tr>
                                            <?php
                                        } elseif ($row['refund_method_id'] == '2') {
                                            $sql_bank_refund = "SELECT bank_name,branch_name,account_holder_name,account_number FROM bank_refund rb "
                                                    . "LEFT JOIN banks b ON b.bank_id=rb.bank_id WHERE refund_request_id='" . $row['refund_request_id'] . "'";
                                            //print_r($sql_bank_name);
                                            $result_bank_refund = $db->query($sql_bank_refund);
                                            $row_bank_refund = $result_bank_refund->fetch_assoc();
                                            ?>
                                            <tr>
                                                <td>Bank Name</td>
                                                <td><?= $row_bank_refund['bank_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Branch Name</td>
                                                <td><?= $row_bank_refund['branch_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Account Holder Name</td>
                                                <td><?= $row_bank_refund['account_holder_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Account Number</td>
                                                <td><?= $row_bank_refund['account_number'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td>Refund Status</td>
                                            <?php
                                            $sql_refund_status = "SELECT refund_status_name FROM refund_status WHERE refund_status_id=" . $row['refund_status_id'];
                                            $result_refund_status = $db->query($sql_refund_status);
                                            $row_refund_status = $result_refund_status->fetch_assoc();
                                            ?>
                                            <td><?= $row_refund_status['refund_status_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Requested Date</td>
                                            <td><?= $row['requested_date'] ?></td>
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
</main>
<?php
include '../footer.php';
?>