<?php
ob_start();
include '../customer/header.php';
include '../customer/sidebar.php';
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Refunds</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>reservation/rejected_reservations.php">Rejected Reservations</a></li>
                <li class="breadcrumb-item active">Request Refund</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
    }
    extract($_POST);
    //var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'request') {
        //Required Field Validation
        $message = array();
        if (empty($refund_method)) {
            $message["error_refund_method"] = "Refund Method Should Not be Blank...";
        }

        if (!empty($refund_method) && $refund_method == '2') {
            if (empty($bank_name)) {
                $message["error_bank"] = "The Bank Should be Selected...";
            }

            if (empty($bank_branch)) {
                $message["error_bank_branch"] = "The Bank Branch Should Not be Blank...";
            }

            if (empty($account_holder)) {
                $message["error_account_holder"] = "The Account Holder's Name Should Not be Blank...";
            }

            if (empty($account_number)) {
                $message["error_account_number"] = "The Account Number Should Not be Blank...";
            }
        }
        if (!empty($refund_method) && $refund_method == '1') {
            if (empty($cash_collector)) {
                $message["error_cash_collector"] = "The Cash Collector Should be Selected...";
            }

            if (!empty($cash_collector) && $cash_collector == 'customer') {
                $db = dbConn();
                $sql = "SELECT first_name,last_name,nic FROM customer WHERE customer_id='" . $_SESSION['customer_id'] . "'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                $collector_name = $row['first_name'] . " " . $row['last_name'];
                $collector_nic = $row['nic'];
            }
            if (!empty($cash_collector) && $cash_collector == 'other') {
                if (empty($collector_name)) {
                    $message["error_collector_name"] = "Cash Collector's Name Should Not be Blank...";
                }else{
                    $collector_name = cleanInput($collector_name);
                    if(!preg_match('/^[A-Za-z ]+$/', $collector_name)){
                        $message["error_collector_name"] = "Name Should not Contain Digits or Special Characters...";
                    }
                }
                if (empty($collector_nic)) {
                    $message["error_collector_nic"] = "Cash Collector's NIC Should Not be Blank...";
                } else {
                    $nic_info = validateNIC($collector_nic);
                    if ($nic_info == FALSE) {
                        $message['error_nic'] = "Invalid NIC...";
                    }
                }
            }
        }

        var_dump($message);
        if (empty($message)) {
            $db = dbConn();
            $sql = "SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'];
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $customer_no = $row['customer_no'];

            $cDate = date('Y-m-d');
            $user_id = $_SESSION['userid'];
            $sql = "INSERT INTO refund_request(reservation_no,customer_no,paid_amount,refundable_amount,"
                    . "refund_method_id,refund_status_id,requested_date,requested_user) "
                    . "VALUES('$reservation_no','$customer_no','$paid_amount','$refundable_amount',"
                    . "'$refund_method','2','$cDate','$user_id')";
            $db->query($sql);

            $refund_request_id = $db->insert_id;

            if ($refund_method == '2') {
                $sql = "INSERT INTO bank_refund(refund_request_id,bank_id,branch_name,account_holder_name,account_number) "
                        . "VALUES('$refund_request_id','$bank_name','$bank_branch','$account_holder','$account_number')";
            }

            if ($refund_method == '1') {
                echo $sql = "INSERT INTO cash_refund(refund_request_id,cash_collector,cash_collector_name,cash_collector_nic) "
                        . "VALUES('$refund_request_id','$cash_collector','$collector_name','$collector_nic')";
            }

            $db->query($sql);

            header('location:refund_request_success.php?request_id=' . $refund_request_id);
        }
    }
    ?>
    <section class="section dashboard">
        <?php
        $db = dbConn();
        $sql = "SELECT * FROM reservation WHERE reservation_no = '$reservation_no'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $reservation_price = $row['discounted_price'];
        ?>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card bg-light" style="font-size:13px;">
                    <div class="card-header">
                        <h3>Request a Refund</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-5 mb-3 mt-3">
                                    <label class="form-label" for="reservation_no">Reservation No</label>
                                </div>
                                <div class="col-md-7 mb-3 mt-3">
                                    <div><?= @$reservation_no ?></div>
                                    <input type="hidden" name="reservation_no" value="<?= @$reservation_no ?>" id="reservation_no">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label" for="reservation_date">Reservation Date</label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <?php
                                    $reservation_date = $row['event_date'];
                                    ?>
                                    <div><?= @$reservation_date ?></div>
                                    <input type="hidden" name="reservation_date" value="<?= @$reservation_date ?>" id="reservation_no">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label" for="reservation_price">Reservation Price (Rs.)</label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <?php
                                    //var_dump($reservation_price);
                                    $reservation_price = str_replace(',', '', $reservation_price);
                                    $reservation_price = number_format($reservation_price, '2', '.', ',');
                                    ?>
                                    <div><?= @$reservation_price ?></div>
                                    <input type="hidden" name="reservation_price" value="<?= str_replace(',', '', @$reservation_price) ?>" id="reservation_price">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label" for="total_price">Total Price (Rs.)<br><span class="text-danger"><strong><i>(Security Fee Included)</i></strong></span></label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT amount FROM payment_category WHERE payment_category_id = '1'";
                                    //print_r($sql);
                                    $result = $db->query($sql);
                                    $row = $result->fetch_assoc();
                                    $total_price = str_replace(',', '', $reservation_price) + $row['amount'];
                                    $total_price = number_format($total_price, '2', '.', ',');
                                    ?>
                                    <div><?= @$total_price ?></div>
                                    <input type="hidden" name="total_price" value="<?= str_replace(',', '', @$total_price) ?>" id="total_price">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Paid Amount (Rs.)</label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <?php
                                    $sql_paid_amount = "SELECT SUM(paid_amount) AS total_paid_amount FROM customer_payments WHERE reservation_no = '$reservation_no' AND payment_status = '6'";
                                    $result_paid_amount = $db->query($sql_paid_amount);
                                    $row_paid_amount = $result_paid_amount->fetch_assoc();
                                    $paid_amount = $row_paid_amount['total_paid_amount'];
                                    ?>
                                    <div><?= number_format($paid_amount, '2', '.', ',') ?></div>
                                    <input type="hidden" name="paid_amount" value="<?= str_replace(',', '', @$paid_amount) ?>" id="paid_amount">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label" for="refundable_amount">Refundable Amount (Rs.)</label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <div><?= number_format($paid_amount, '2', '.', ',') ?></div>
                                    <input type="hidden" name="refundable_amount" value="<?= str_replace(',', '', @$paid_amount) ?>" id="refundable_amount">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Expected Refund Method</label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <select name="refund_method" id="refund_method" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                        <option value="">Select a Payment Method</option>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM payment_method WHERE availability='Available' AND method_id != '3'";
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value=<?= $row['method_id']; ?> <?php if ($row['method_id'] == @$refund_method) { ?> selected <?php } ?>><?= $row['method_name'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger"><?= @$message["error_refund_method"] ?></div>
                                </div>
                            </div>
                            <?php
                            if (!empty($refund_method)) {
                                if ($refund_method == '2') {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label">Bank Name</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <select name="bank_name" id="bank_name" class="form-control form-select" style="font-size:12px;">
                                                <option value="">Select a Bank</option>
                                                <?php
                                                $db = dbConn();
                                                $sql = "SELECT * FROM banks";
                                                $result = $db->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                        <option value=<?= $row['bank_id']; ?> <?php if ($row['bank_id'] == @$bank_name) { ?> selected <?php } ?>><?= $row['bank_name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="text-danger"><?= @$message["error_bank"] ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label">Branch Name</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <input type="text" name="bank_branch" value="<?= @$bank_branch ?>" class="form-control" id="bank_branch" style="font-size:12px;">
                                            <div class="text-danger"><?= @$message["error_bank_branch"] ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label">Account Holder Name</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <input type="text" name="account_holder" value="<?= @$account_holder ?>" id="account_holder" class="form-control" style="font-size:12px;">
                                            <div class="text-danger"><?= @$message["error_account_holder"] ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label">Account Number</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <input type="text" name="account_number" value="<?= @$account_number ?>" id="account_number" class="form-control" style="font-size:12px;">
                                            <div class="text-danger"><?= @$message["error_account_number"] ?></div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif ($refund_method == '1') {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label class = "form-label">Cash Collected By</label>
                                        </div>
                                        <div class = "col-md-7 mb-3">
                                            <select name = "cash_collector" id = "cash_collector" class = "form-control form-select" style = "font-size:12px;" onchange="form.submit()">
                                                <option value = "">Select the Cash Collector</option>
                                                <option value="customer" <?php if (@$cash_collector == 'customer') { ?> selected <?php } ?>>Myself</option>
                                                <option value="other" <?php if (@$cash_collector == 'other') { ?> selected <?php } ?>>Other Person</option>
                                            </select>
                                            <div class="text-danger"><?= @$message["error_cash_collector"] ?></div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <?php
                            if (!empty($refund_method) && $refund_method == '1' && !empty($cash_collector) && $cash_collector == 'other') {
                                ?>
                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label">Collector's Name</label>
                                    </div>
                                    <div class="col-md-7 mb-3">
                                        <input type="text" name="collector_name" value="<?= @$collector_name ?>" id="collector_name" class="form-control" style="font-size:12px;">
                                        <div class="text-danger"><?= @$message["error_collector_name"] ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label">Collector's NIC</label>
                                    </div>
                                    <div class="col-md-7 mb-3">
                                        <input type="text" name="collector_nic" value="<?= @$collector_nic ?>" id="collector_nic" class="form-control" style="font-size:12px;">
                                        <div class="text-danger"><?= @$message["error_collector_nic"] ?></div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <div class="row">
                                <div class="col-md-12" style="text-align:right">
                                    <button type="cancel" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;">Cancel</button>
                                    <button type="submit" name="action" value="request" class="btn btn-success btn-sm" style="font-size:13px;width:100px;">Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </section>
</main>
<?php include '../customer/footer.php'; ?>