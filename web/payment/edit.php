<?php
ob_start();
include '../customer/header.php';
include '../customer/sidebar.php';
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Payments</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>payment/payment.php">Payment</a></li>
                <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>payment/pending_payments.php">Pending Payments</a></li>
                <li class="breadcrumb-item active">Update Payment</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
        $db = dbConn();
        $sql = "SELECT * FROM customer_payments WHERE receipt_no = '$receipt_no'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $payment_id = $row['payment_id'];
        $reservation_no = $row['reservation_no'];
        $reservation_price = $row['reservation_price'];
        $total_price = $row['total_price'];
        $payment_category = $row['payment_category_id'];
        $paying_amount = $row['paid_amount'];
        $bank_name = $row['bank_id'];
        $paid_date = $row['paid_date'];
        $payment_method = $row['payment_method_id'];
        
        if($payment_method == '2'){
            $sql_pay_bank = "SELECT * FROM customer_payment_bank WHERE payment_id = '$payment_id'";
            $result_pay_bank = $db->query($sql_pay_bank);
            $row_pay_bank = $result_pay_bank->fetch_assoc();
            $bank_branch = $row_pay_bank['bank_branch'];
        }
        if($payment_method == '3'){
            $sql_pay_online = "SELECT * FROM customer_payment_online WHERE payment_id = '$payment_id'";
            $result_pay_online = $db->query($sql_pay_online);
            $row_pay_online = $result_pay_online->fetch_assoc();
            $reference_no = $row_pay_online['reference_no'];
        }
        $pay_slip = $row['pay_slip'];
        $prev_image = $row['pay_slip'];
        $balance_amount = $row['balance_amount'];
    }
    
    extract($_POST);
    //var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'pay') {
        //Required Field Validation
        $message = array();
        if (empty($payment_category)) {
            $message["error_payment_category"] = "You Should Select a Payment Category";
        }

        if (empty($payment_method)) {
            $message["error_payment_method"] = "You Should Select a Payment Method";
        }
        if (empty($bank_name)) {
            $message["error_bank"] = "The Bank Should be Selected";
        }
        if (!empty($payment_method) && $payment_method == '2') {
            if (empty($bank_branch)) {
                $message["error_bank_branch"] = "The Bank Branch Should not be blank";
            }
        }
        if (!empty($payment_method) && $payment_method == '3') {
            if (empty($reference_no)) {
                $message["error_reference_no"] = "The Reference No Should not be blank";
            }
        }

        if (empty($message) && !empty($_FILES['pay_slip']['name'])) {
            $saved_name = date('Y') . date('m') . date('d') . $reservation_no . uniqid();
            $pay_slip = uploadFiles("pay_slip", $saved_name, "../assets/img/pay_slip/customer/");
            //print_r($pay_slip);
            $pay_slip_name = $pay_slip['file_name'];
            if (!empty($pay_slip['error_message'])) {
                $message['error_pay_slip'] = $pay_slip['error_message'];
            }
        } else {
            $pay_slip_name = $prev_image;
        }
        
        var_dump($message);
        if (empty($message)) {
            $db = dbConn();
            $sql = "SELECT customer_no,user_id FROM customer WHERE customer_id=" . $_SESSION['customer_id'];
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $customer_no = $row['customer_no'];
            $user_id = $row['user_id'];
            $cDate = date('Y-m-d');

            $sql = "UPDATE customer_payments SET payment_category_id = '$payment_category',"
                    . "paid_amount = '$paying_amount',paid_date = '$paid_date',payment_method_id = '$payment_method',"
                    . "bank_id = '$bank_name',pay_slip = '$pay_slip_name',balance_amount = '$balance_amount',payment_status = '1',"
                    . "update_user = '$user_id',update_date = '$cDate' WHERE payment_id = '$payment_id'";
            $db->query($sql);

            $sql = "DELETE FROM customer_payment_bank WHERE payment_id = '$payment_id'";
            $db->query($sql);
            
            $sql = "DELETE FROM customer_payment_online WHERE payment_id = '$payment_id'";
            $db->query($sql);
            
            if ($payment_method == '2') {
                $sql = "INSERT INTO customer_payment_bank(payment_id,bank_branch) VALUES('$payment_id','$bank_branch')";
            }

            if ($payment_method == '3') {
                echo $sql = "INSERT INTO customer_payment_online(payment_id,reference_no) VALUES('$payment_id','$reference_no')";
            }

            $db->query($sql);

            header('location:make_payment_success.php?payment_id=' . $payment_id);
        }
    }
    ?>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card bg-light" style="font-size:13px;">
                    <div class="card-header">
                        <h3>Make a Payment</h3>
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
                                    <label class="form-label">Payment Category</label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <?php
                                    $db = dbConn();
                                    //$sql = "SELECT * FROM payment_category WHERE payment_category_id NOT IN (SELECT payment_category_id FROM customer_payments WHERE reservation_no = '$reservation_no')";
                                    $sql = "SELECT MAX(payment_category_id) as last_paid FROM customer_payments WHERE reservation_no = '$reservation_no' AND (payment_status = '1' OR payment_status = '3')";
                                    //print_r($sql);
                                    $result = $db->query($sql);
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        //var_dump($row);
                                        if ($row['last_paid'] == '2' || $row['last_paid'] == '4') {
                                            $sql_category = "SELECT * FROM payment_category WHERE payment_category_id !='1' AND payment_category_id != '3'";
                                        } elseif ($row['last_paid'] == '3') {
                                            $sql_category = "SELECT * FROM payment_category WHERE payment_category_id ='3'";
                                        } elseif ($row['last_paid'] == '1') {
                                            $sql_category = "SELECT * FROM payment_category WHERE payment_category_id ='1'";
                                        }
                                    }
                                    $result_category = $db->query($sql_category);
                                    ?>
                                    <select name="payment_category" id="payment_category" class="form-control form-select" onchange="form.submit()" style="font-size:12px;">
                                        <option value="">Select a Payment Category</option>
                                        <?php
                                        while ($row_category = $result_category->fetch_assoc()) {
                                            if ($row_category['payment_category_id'] == '1') {
                                                $value = $row_category['amount'];
                                                $value = number_format($value, '2', '.', ',');
                                            } else {
                                                $value = $row_category['ratio'] * 100;
                                                $value = number_format($value, '2') . "%";
                                            }
                                            ?>
                                            <option value=<?= $row_category['payment_category_id']; ?> <?php if ($row_category['payment_category_id'] == @$payment_category) { ?> selected <?php } ?>><?= $row_category['payment_category_name'] . ' - (' . $value . ')' ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger"><?= @$message["error_payment_category"] ?></div>
                                </div>
                            </div>

                            <?php
                            if (!empty($payment_category)) {
                                $db = dbConn();
                                $sql = "SELECT amount,ratio FROM payment_category WHERE payment_category_id='$payment_category'";
                                $result = $db->query($sql);
                                $row = $result->fetch_assoc();

                                if ($payment_category == '1') {
                                    $paying_amount = $row['amount'];
                                } else {
                                    $paying_amount = str_replace(',', '', $reservation_price) * $row['ratio'];
                                }
                                $paying_amount = number_format($paying_amount, '2', '.', ',');
                                ?>
                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label" for="paying_amount">Paying Amount (Rs.)</label>
                                    </div>
                                    <div class="col-md-7 mb-3">
                                        <div><?= @$paying_amount ?></div>
                                        <input type="hidden" name="paying_amount" value="<?= str_replace(',', '', @$paying_amount) ?>" id="paying_amount">
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label" for="paid_date">Paid Date</label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT add_date FROM reservation WHERE reservation_no='$reservation_no'";
                                    $result = $db->query($sql);
                                    $row = $result->fetch_assoc();
                                    $max = date('Y-m-d');
                                    ?>
                                    <input type="date" class="form-control" min="<?= $row['add_date'] ?>" max="<?= $max ?>" name="paid_date" value="<?= @$paid_date ?>" id="paid_date" style="font-size:12px;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Payment Method</label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <select name="payment_method" id="payment_method" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                        <option value="">Select a Payment Method</option>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM payment_method WHERE availability='Available' AND method_id != '1'";
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value=<?= $row['method_id']; ?> <?php if ($row['method_id'] == @$payment_method) { ?> selected <?php } ?>><?= $row['method_name'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger"><?= @$message["error_payment_method"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Bank Name</label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <select name="bank_name" id="bank_name" class="form-control form-select" style="font-size:12px;">
                                        <option value="">Select a Bank</option>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM bank_details";
                                        $result = $db->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value=<?= $row['bank_detail_id']; ?> <?php if ($row['bank_detail_id'] == @$bank_name) { ?> selected <?php } ?>><?= $row['bank_name'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger"><?= @$message["error_bank"] ?></div>
                                </div>
                            </div>
                            <?php
                            if (!empty($payment_method)) {
                                if ($payment_method == '2') {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label">Bank Branch</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <input type="text" name="bank_branch" value="<?= @$bank_branch ?>" id="bank_branch" class="form-control" style="font-size:12px;">
                                            <div class="text-danger"><?= @$message["error_bank_branch"] ?></div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <?php
                            if (!empty($payment_method)) {
                                if ($payment_method == '3') {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label">Reference No</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <input type="text" name="reference_no" value="<?= @$reference_no ?>" id="reference_no" class="form-control" style="font-size:12px;">
                                            <div class="text-danger"><?= @$message["error_reference_no"] ?></div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label" for="pay_slip">Pay Slip</label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <?php
                                    if (!empty($_FILES)) {
                                        $prev_image = $_FILES['pay_slip']['name'];
                                    }
                                    ?>
                                    <input type="hidden" name="prev_image" value="<?= @$prev_image ?>">
                                    <input type="file" name="pay_slip" value="" id="pay_slip" class="form-control" style="font-size:12px;">
                                    <div class="text-danger"><?= @$message["error_pay_slip"] ?></div>
                                </div>
                            </div>
                            <?php
                            if (!empty($payment_category)) {
                                if ($payment_category == '1') {
                                    $balance_amount = str_replace(',', '', $reservation_price);
                                } elseif ($payment_category == '2') {
                                    $balance_amount = str_replace(',', '', $reservation_price) - str_replace(',', '', $paying_amount);
                                } else {
                                    $balance_amount = str_replace(',', '', $reservation_price) - str_replace(',', '', $reservation_price);
                                }
                                $balance_amount = number_format($balance_amount, '2', '.', ',');
                                ?>
                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label">Balance Amount (Rs.)</label>
                                    </div>
                                    <div class="col-md-7 mb-3">
                                        <div><?= @$balance_amount ?></div>
                                        <input type="hidden" readonly name="balance_amount" value="<?= str_replace(',', '', @$balance_amount) ?>" id="balance_amount" class="form-control">
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-12" style="text-align:right">
                                    <input type="hidden" name="payment_id" value="<?= @$payment_id?>">
                                    <button type="cancel" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;">Cancel</button>
                                    <button type="submit" name="action" value="pay" class="btn btn-success btn-sm" style="font-size:13px;width:100px;">Pay</button>
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