<?php
ob_start();
include '../header.php';
include '../menu.php';
include '../assets/phpmail/mail.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>customer_payment/received.php">Received Payments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Verify</li>
            </ol>
        </nav>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
        $payment_id = $_GET['payment_id'];
        //var_dump($row);
    }
    extract($_POST);
    //var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'verify') {
        $message = array();
        if (empty($verification)) {
            $message["error_verification"] = "Verification Status Should be Selected";
        }
        if (empty($message)) {
            $db = dbConn();
            $cDate = date('Y-m-d');
            $user_id = $_SESSION['userid'];
            if ($verification == 'Verified') {
                $sql = "UPDATE customer_payments SET payment_status = '2',verified_date='$cDate',verified_user='$user_id' WHERE payment_id = '$payment_id'";
            } elseif ($verification == 'Unsuccessful') {
                $sql = "UPDATE customer_payments SET payment_status = '3',verified_date='$cDate',verified_user='$user_id' WHERE payment_id = '$payment_id'";
            }
            //print_r($sql);
            $db->query($sql);

            $sql = "SELECT reservation_no FROM customer_payments WHERE payment_id ='$payment_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $reservation_no = $row['reservation_no'];
            if ($verification == 'Verified') {
                if ($payment_category == '1') {
                    $sql = "UPDATE reservation SET reservation_payment_status_id = '6',reservation_status_id='2' WHERE reservation_no = '$reservation_no'";
                } elseif ($payment_category == '2') {
                    $sql = "UPDATE reservation SET reservation_payment_status_id = '2' WHERE reservation_no = '$reservation_no'";
                } elseif ($payment_category == '3' || $payment_category == '4') {
                    $sql = "UPDATE reservation SET reservation_payment_status_id = '3' WHERE reservation_no = '$reservation_no'";
                }
            }

            $db->query($sql);
            header('location:customer_payment.php');
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'reject') {
        $message = array();
        if (empty($verification)) {
            $message["error_verification"] = "Verification Status Should be Selected";
        }
        if (empty($message)) {
            $db = dbConn();
            $cDate = date('Y-m-d');
            $user_id = $_SESSION['userid'];
            if ($verification == 'Verified') {
                $sql = "UPDATE customer_payments SET payment_status = '6',rejected_date='$cDate',rejected_user='$user_id' WHERE payment_id = '$payment_id'";
            } elseif ($verification == 'Unsuccessful') {
                $sql = "UPDATE customer_payments SET payment_status = '3',verified_date='$cDate',verified_user='$user_id' WHERE payment_id = '$payment_id'";
            }
            //print_r($sql);
            $db->query($sql);

            $sql = "SELECT reservation_no FROM customer_payments WHERE payment_id ='$payment_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $reservation_no = $row['reservation_no'];
            if ($verification == 'Verified') {
                $sql = "UPDATE reservation SET reservation_payment_status_id = '7',reservation_status_id='4' WHERE reservation_no = '$reservation_no'";
            }
            $db->query($sql);

            $sql = "SELECT email,first_name,last_name FROM customer WHERE customer_no=(SELECT customer_no FROM customer_payments WHERE payment_id ='$payment_id')";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $email = $row['email'];
            $to = $email;
            $recepient_name = $first_name . " " . $last_name;
            $subject = 'Flash Reception Hall - Rejection of the Reservation';
            $body = "<p>Dear " . $first_name . "</p>";
            $body .= "<br><br>";
            $body .= "<p>Unfortunately the time slot you selected was secured by another customer before you make the payment. "
                    . "According to our policy we have to reject your reservation. "
                    . "We are truly apologize for the inconvenience caused by this rejection. "
                    . "You are eligible for a full refund on your payment. You can claim it by visiting your user account.</p>";
            $body .= "<br><br>";
            $body .= "You can check if the other hall is available for your reservation or make another reservation for another date if it is convenient.";
            $body .= "<br><br>";
            $body .= "<p>http://localhost/flash_reception_hall/web/customer/login.php</p>";
            $body .= "<p>Upon logging in, you will be able to access rejected reservations and request the refund.</p>";
            $body .= "<br><br>";
            $body .= "<p>Thank You,</p><br><p>Flash Reception Hall.</p>";
            $alt_body = "<p>Your Reservation was Rejected due to the unavailability</p>";
            send_email($to, $recepient_name, $subject, $body, $alt_body);

            header('location:customer_payment.php');
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
                                            <th colspan="2">Payment Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM customer_payments WHERE payment_id='$payment_id'";
                                        $result = $db->query($sql);
                                        $row = $result->fetch_assoc();
                                        ?>
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
                                        <?php
                                        if ($row['payment_method_id'] != '1') {
                                            ?>
                                            <tr>
                                                <td>Paid Bank</td>
                                                <?php
                                                $sql_bank_name = "SELECT b.bank_name FROM bank_details b LEFT JOIN customer_payments p ON p.bank_id=b.bank_detail_id WHERE p.payment_id='$payment_id'";
                                                $result_bank_name = $db->query($sql_bank_name);
                                                $row_bank_name = $result_bank_name->fetch_assoc();
                                                ?>
                                                <td><?= $row_bank_name['bank_name'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
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
                                                <td>Paid Bank</td>
                                                <?php
                                                $sql_ref_no = "SELECT co.reference_no FROM customer_payments p "
                                                        . "LEFT JOIN customer_payment_online co ON co.payment_id=p.payment_id WHERE p.payment_id='$payment_id'";
                                                //print_r($sql_bank_name);
                                                $result_ref_no = $db->query($sql_ref_no);
                                                $row_ref_no = $result_ref_no->fetch_assoc();
                                                ?>
                                                <td><?= $row_ref_no['reference_no'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                        if ($row['payment_method_id'] != '1') {
                            ?>
                            <div class="col-md-6">
                                <a href="../../web/assets/img/pay_slip/customer/<?= $row['pay_slip'] ?>"><img src="../../web/assets/img/pay_slip/customer/<?= $row['pay_slip'] ?>" style="width:350px;height:350px;"></a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-2 col-md-3">
                                            <label class="form-label"><span class="text-danger">*</span> Verification</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="verification" id="verified" value="Verified" <?php if (isset($verification) && @$verification == 'Verified') { ?> checked <?php } ?> style="font-size:13px;">
                                                <label class="form-check-label" for="verified">Verified</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="verification" id="unsuccessful" value="Unsuccessful" <?php if (isset($verification) && (@$verification == 'Unsuccessful')) { ?> checked <?php } ?> style="font-size:13px;">
                                                <label class="form-check-label" for="unsuccessful">Unsuccessful</label>
                                            </div>
                                            <div class="text-danger"><?= @$message["error_verification"] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $db = dbConn();
                                $sql_paid_res = "SELECT * FROM reservation WHERE reservation_no="
                                        . "(SELECT reservation_no FROM customer_payments WHERE payment_id = '$payment_id')";
                                $result_paid_res = $db->query($sql_paid_res);
                                $row_paid_res = $result_paid_res->fetch_assoc();

                                $sql_conflict = "SELECT reservation_no FROM reservation WHERE event_date='" . $row_paid_res['event_date'] . "' "
                                        . "AND  reservation_status_id = '2' AND hall_id = '" . $row_paid_res['hall_id'] . "' "
                                        . "AND ((start_time BETWEEN '" . $row_paid_res['start_time'] . "' AND '" . $row_paid_res['end_time'] . "') "
                                        . "OR (end_time BETWEEN '" . $row_paid_res['start_time'] . "' AND '" . $row_paid_res['end_time'] . "') "
                                        . "OR (start_time <= '" . $row_paid_res['start_time'] . "' AND end_time >= '" . $row_paid_res['end_time'] . "') "
                                        . "OR (start_time = '" . $row_paid_res['end_time'] . "') "
                                        . "OR (end_time = '" . $row_paid_res['start_time'] . "'))";
                                $result_conflict = $db->query($sql_conflict);
                                if ($result_conflict->num_rows > 0) {
                                    $conflict_res = $result_conflict->fetch_assoc();
                                    if ($conflict_res['reservation_no'] != $row['reservation_no']) {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12" style="text-align:left">
                                                <input type="hidden" name="payment_category" value="<?= $row['payment_category_id'] ?>">
                                                <input type="hidden" name="payment_id" value="<?= @$payment_id ?>">
                                                <button type="submit" name="action" value="reject" class="btn btn-success btn-sm" style="width:100px;font-size:13px;">Reject</button>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12" style="text-align:left">
                                                <input type="hidden" name="payment_category" value="<?= $row['payment_category_id'] ?>">
                                                <input type="hidden" name="payment_id" value="<?= @$payment_id ?>">
                                                <button type="submit" name="action" value="verify" class="btn btn-success btn-sm" style="width:100px;font-size:13px;">Submit</button>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align:left">
                                            <input type="hidden" name="payment_category" value="<?= $row['payment_category_id'] ?>">
                                            <input type="hidden" name="payment_id" value="<?= @$payment_id ?>">
                                            <button type="submit" name="action" value="verify" class="btn btn-success btn-sm" style="width:100px;font-size:13px;">Submit</button>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

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