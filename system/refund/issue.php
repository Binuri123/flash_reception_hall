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
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'issue') {

        $db = dbConn();
        $cDate = date('Y-m-d');
        $user_id = $_SESSION['userid'];
        $refund_invoice_no = date('Y').date('m').date('d').$request_id;
        $sql = "UPDATE refund_request SET refund_no = '$refund_invoice_no',issued_date = '$cDate',issued_user='$user_id',refund_status_id='5' WHERE refund_request_id = '$request_id'";

        //print_r($sql);
        $db->query($sql);
        $sql = "SELECT reservation_no FROM refund_request WHERE refund_request_id='$request_id'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $reservation_no = $row['reservation_no'];

        $sql = "UPDATE reservation SET reservation_payment_status_id = '4' WHERE reservation_no = '$reservation_no'";
        $db->query($sql);

        header('location:refund/refund.php');
    }
    ?>
    <div class="row mb-3">
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
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <label class="form-label" style="font-size:13px;">Approved Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div style="font-size:13px;"><?= $row['approved_date'] ?></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <label class="form-label" style="font-size:13px;">Approved By</label>
                                    </div>
                                    <div class="col-md-8">
                                        <?php
                                        $db = dbConn();
                                        $sql_approved_user = "SELECT title,first_name,last_name,role_name FROM user u "
                                                . "LEFT JOIN employee e ON u.user_id=e.user_id "
                                                . "LEFT JOIN user_role ur ON ur.user_role_id=u.user_role_id "
                                                . "WHERE u.user_id='" . $row['approved_user'] . "'";
                                        $result_approved_user = $db->query($sql_approved_user);
                                        $row_approved_user = $result_approved_user->fetch_assoc();
                                        $approved_user_name = $row_approved_user['title'] . " " . $row_approved_user['first_name'] . " " . $row_approved_user['last_name'] . " (" . $row_approved_user['role_name'] . ")";
                                        ?>
                                        <div style="font-size:13px;"><?= $approved_user_name ?></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <label class="form-label" style="font-size:13px;">Issuing Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div style="font-size:13px;"><?= date('Y-m-d') ?></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <label class="form-label" style="font-size:13px;">Issued By</label>
                                    </div>
                                    <div class="col-md-8">
                                        <?php
                                        $db = dbConn();
                                        $sql_issued_user = "SELECT title,first_name,last_name,role_name FROM user u "
                                                . "LEFT JOIN employee e ON u.user_id=e.user_id "
                                                . "LEFT JOIN user_role ur ON ur.user_role_id=u.user_role_id WHERE u.user_id='" . $_SESSION['userid'] . "'";
                                        $result_issued_user = $db->query($sql_issued_user);
                                        $row_issued_user = $result_issued_user->fetch_assoc();
                                        $issued_user_name = $row_issued_user['title'] . " " . $row_issued_user['first_name'] . " " . $row_issued_user['last_name'] . " (" . $row_issued_user['role_name'] . ")";
                                        ?>
                                        <div style="font-size:13px;"><?= $issued_user_name ?></div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <label class="form-label" style="font-size:13px;">Invoice</label>
                                    </div>
                                    <div class="col-md-8">
                                        <button type="button" class="btn btn-secondary" onclick="printReport('invoice')" style="font-size:13px;width:100px;height:30px;padding:0px;"><i class="bi bi-printer-fill"></i> Print Invoice</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 " style="text-align:right">
                                        <input type="hidden" name="request_id" value="<?= @$request_id ?>">
                                        <button type="submit" name="action" value="issue" class="btn btn-success btn-sm" style="width:100px;font-size:13px;">Submit</button>
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
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div id="invoice">
                <div class="row">
                    <div class="card bg-white">
                        <div class="card-header bg-white text-center">
                            <h4>Flash Reception Hall</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mt-2 mb-3">
                                <div class="col-md-6">Reservation No</div>
                                <div class="col-md-6"><?= $row['reservation_no'] ?></div>
                            </div>
                            <div class="row mt-2 mb-3">
                                <div class="col-md-6">Customer No</div>
                                <div class="col-md-6"><?= $row['customer_no'] ?></div>
                            </div>
                            <div class="row mt-2 mb-3">
                                <div class="col-md-6">Customer Name</div>
                                <?php
                                $sql_customer_name = "SELECT title_name,first_name,last_name FROM customer c "
                                        . "LEFT JOIN customer_titles ct ON ct.title_id = c.title_id "
                                        . "WHERE customer_no ='" . $row['customer_no'] . "'";
                                $result_customer_name = $db->query($sql_customer_name);
                                $row_customer_name = $result_customer_name->fetch_assoc();
                                ?>
                                <div class="col-md-6"><?= $row_customer_name['title_name'] . " " . $row_customer_name['first_name'] . " " . $row_customer_name['last_name'] ?></div>
                            </div>
                            <div class="row mt-2 mb-3">
                                <div class="col-md-6">Issued Date</div>
                                <div class="col-md-6"><?= date('Y-m-d H:i:s') ?></div>
                            </div>
                            <div class="row mt-2 mb-3">
                                <div class="col-md-6">Paid Amount (Rs.)</div>
                                <div class="col-md-6"><?= number_format($row['paid_amount'], '2', '.', ',') ?></div>
                            </div>
                            <div class="row mt-2 mb-3">
                                <div class="col-md-6">Refunded Amount (Rs.)</div>
                                <div class="col-md-6"><?= number_format($row['refundable_amount'], '2', '.', ',') ?></div>
                            </div>
                            <div class="row mt-2 mb-3">
                                <div class="col-md-6">Refund Method</div>
                                <div class="col-md-6"><?= $refund_method ?></div>
                            </div>
                            <?php
                            if ($row['refund_method_id'] == '1') {
                                ?>
                                <div class="row mt-2 mb-3">
                                    <div class="col-md-6">Cash Collector's Name</div>
                                    <div class="col-md-6"><?= $row_cash_refund['cash_collector_name'] ?></div>
                                </div>
                                <div class="row mt-2 mb-3">
                                    <div class="col-md-6">Cash Collector's NIC</div>
                                    <div class="col-md-6"><?= $row_cash_refund['cash_collector_nic'] ?></div>
                                </div>
                                <?php
                            } elseif ($row['refund_method_id'] == '2') {
                                ?>
                                <div class="row mt-2 mb-3">
                                    <div class="col-md-6">Bank Name</div>
                                    <div class="col-md-6"><?= $row_bank_refund['bank_name'] ?></div>
                                </div>
                                <div class="row mt-2 mb-3">
                                    <div class="col-md-6">Branch Name</div>
                                    <div class="col-md-6"><?= $row_bank_refund['branch_name'] ?></div>
                                </div>
                                <div class="row mt-2 mb-3">
                                    <div class="col-md-6">Account Holder Name</div>
                                    <div class="col-md-6"><?= $row_bank_refund['account_holder_name'] ?></div>
                                </div>
                                <div class="row mt-2 mb-3">
                                    <div class="col-md-6">Account Number</div>
                                    <div class="col-md-6"><?= $row_bank_refund['account_number'] ?></div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="row mt-2 mb-3">
                                <div class="col-md-6">Issued By</div>
                                <?php
                                $db = dbConn();
                                $sql_issued_user = "SELECT title,first_name,last_name,role_name FROM user u "
                                        . "LEFT JOIN employee e ON u.user_id=e.user_id "
                                        . "LEFT JOIN user_role ur ON ur.user_role_id=u.user_role_id WHERE u.user_id='" . $_SESSION['userid'] . "'";
                                $result_issued_user = $db->query($sql_issued_user);
                                $row_issued_user = $result_issued_user->fetch_assoc();
                                $issued_user_name = $row_issued_user['title'] . " " . $row_issued_user['first_name'] . " " . $row_issued_user['last_name'] . " (" . $row_issued_user['role_name'] . ")";
                                ?>
                                <div class="col-md-6"><?= $issued_user_name ?></div>
                            </div>
                            <?php
                            if ($row['refund_method_id'] == '1') {
                                ?>
                                <div class="row mt-2 mb-3">
                                    <div class="col-md-6">Collector's Signature</div>
                                    <div class="col-md-6">...................................</div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</main>
<?php
ob_end_flush();
include '../footer.php';
?>