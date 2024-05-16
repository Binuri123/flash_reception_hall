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
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>refund/refund_request.php">Refund Requests</a></li>
                <li class="breadcrumb-item active" aria-current="page">Approval</li>
            </ol>
        </nav>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
        $request_id = $_GET['request_id'];
        //var_dump($row);
    }
    extract($_POST);
    //var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'approve') {
        $message = array();
        if (empty($approval)) {
            $message["error_approval"] = "Approval Status Should be Selected...";
        }elseif($approval == 'Pending'){
            if(empty($pending_reason)){
                $message["error_pending_reason"] = "Pending Reason Should Not be Blank...";
            }
        }
        if (empty($message)) {
            $db = dbConn();
            $cDate = date('Y-m-d');
            $user_id = $_SESSION['userid'];
            if ($approval == 'Approve') {
                $sql = "UPDATE refund_request SET approved_date = '$cDate',approved_user='$user_id',refund_status_id='4' WHERE refund_request_id = '$request_id'";
            } elseif ($approval == 'Pending') {
                $sql = "UPDATE refund_request SET refund_status_id='3',update_date='$cDate',update_user='$user_id' WHERE refund_request_id = '$request_id'";
            }
            //print_r($sql);
            $db->query($sql);
            
            if ($approval == 'Pending') {
                $sql = "INSERT INTO refund_pending_reason(refund_request_id,pending_reason) VALUES('$request_id','$pending_reason')";
            }
            //print_r($sql);
            $db->query($sql);
            
            header('location:refund/refund.php');
        }
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
                                            <th colspan="2">Refund Request Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM refund_request WHERE refund_request_id='$request_id'";
                                        $result = $db->query($sql);
                                        $row = $result->fetch_assoc();
                                        ?>
                                        <tr>
                                            <td>Reservation No</td>
                                            <td><?= $row['reservation_no'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Customer No</td>
                                            <td><?= $row['customer_no'] ?></td>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label" style="font-size:13px;">Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <?php
                                        $today = date('Y-m-d');
                                        ?>
                                        <div style="font-size:13px;"><?= @$today ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-md-4">
                                        <label class="form-label" style="font-size:13px;"><span class="text-danger">*</span> Approval</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" style="font-size:13px;" type="radio" name="approval" id="approve" value="Approve" <?php if (isset($approval) && @$approval == 'Approve') { ?> checked <?php } ?> style="font-size:13px;" onchange="form.submit()">
                                            <label class="form-check-label" style="font-size:13px;" for="approve">Approve</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" style="font-size:13px;" type="radio" name="approval" id="pending" value="Pending" <?php if (isset($approval) && (@$approval == 'Pending')) { ?> checked <?php } ?> style="font-size:13px;" onchange="form.submit()">
                                            <label class="form-check-label" style="font-size:13px;" for="pending">Pending</label>
                                        </div>
                                        <div class="text-danger"><?= @$message["error_approval"] ?></div>
                                    </div>
                                </div>
                                <?php
                                if (!empty($approval) && $approval == 'Pending') {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label"><span class="text-danger">*</span> Reason</label>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <textarea name="pending_reason" value="<?= @$pending_reason ?>" id="pending_reason" class="form-control" placeholder="Ex: Insufficient Funds" style="font-size:13px;"></textarea>
                                            <div class="text-danger"><?= @$message["error_pending_reason"] ?></div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="row">
                                    <div class="col-md-12 " style="text-align:right">
                                        <input type="hidden" name="request_id" value="<?= @$request_id ?>">
                                        <button type="submit" name="action" value="approve" class="btn btn-success btn-sm" style="width:100px;font-size:13px;">Submit</button>
                                    </div>
                                </div>
                            </form>
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