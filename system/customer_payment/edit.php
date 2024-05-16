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
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>customer_payment/customer_payment.php">Customer Payment</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>customer_payment/pending.php">Pending Payment</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update a Payment</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Make a Payment</h3>
        </div>
    </div>
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
        $paid_date = $row['paid_date'];
        $payment_method = $row['payment_method_id'];
    }
    extract($_POST);
    //var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'pay') {
        //Required Field Validation
        $message = array();

        if (empty($payment_category)) {
            $message["error_payment_category"] = "You Should Select a Payment Category";
        }
        if (empty($paid_date)) {
            $message["error_paid_date"] = "You Should Select the Paid Date";
        }

        var_dump($message);
        if (empty($message)) {
            $db = dbConn();
            $sql = "SELECT customer_no FROM reservation WHERE reservation_no='$reservation_no'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $customer_no = $row['customer_no'];

            $user_id = $_SESSION['userid'];
            $cDate = date('Y-m-d');

            echo $sql = "UPDATE customer_payments SET reservation_no = '$reservation_no',customer_no = '$customer_no',"
                    . "reservation_price = '$reservation_price',total_price = '$total_price',"
                    . "payment_category_id = '$payment_category',paid_amount = '$paying_amount',paid_date = '$paid_date'"
                    . ",payment_method_id ='1',balance_amount = '$balance_amount',"
                    . "payment_status = '1',update_user = '$user_id',update_date = '$cDate' WHERE payment_id = '$payment_id'";
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
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-5 mb-3 mt-1">
                                    <label class="form-label" for="customer_name">Customer Name</label>
                                </div>
                                <div class="col-md-7 mb-3 mt-1">
                                    <div>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT c.customer_no,t.title_name,c.first_name,c.last_name FROM customer c "
                                                . "LEFT JOIN customer_titles t ON t.title_id=c.title_id "
                                                . "WHERE c.customer_no = (SELECT customer_no FROM reservation WHERE reservation_no='$reservation_no')";
                                        $result = $db->query($sql);
                                        $row = $result->fetch_assoc();
                                        echo $row['title_name'] . " " . $row['first_name'] . " " . $row['last_name'];
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label" for="customer_no">Customer No</label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <div>
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT customer_no FROM reservation WHERE reservation_no='$reservation_no'";
                                        $result = $db->query($sql);
                                        $row = $result->fetch_assoc();
                                        echo $row['customer_no'];
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label" for="reservation_no">Reservation No</label>
                                </div>
                                <div class="col-md-7 mb-3">
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
                                    $sql = "SELECT MAX(payment_category_id) as last_paid FROM customer_payments WHERE reservation_no = '$reservation_no' AND payment_status = '4'";
                                    //print_r($sql);
                                    $result = $db->query($sql);
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        //var_dump($row);
                                        if ($row['last_paid'] == '1') {
                                            $sql_category = "SELECT * FROM payment_category WHERE payment_category_id !='1' AND payment_category_id != '3'";
                                        } elseif ($row['last_paid'] == '2') {
                                            $sql_category = "SELECT * FROM payment_category WHERE payment_category_id ='3'";
                                        } elseif ($row['last_paid'] == NULL) {
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
                                    $today = date('Y-m-d');
                                    ?>
                                    <div><?= @$today ?></div>
                                    <input type="hidden" name="paid_date" value="<?= @$today ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Payment Method</label>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM payment_method WHERE method_id = '1'";
                                    $result = $db->query($sql);
                                    $row = $result->fetch_assoc()
                                    ?>
                                    <div><?= $row['method_name'] ?></div>
                                    <input type="hidden" name="payment_method" value="<?= $row['method_id']; ?>">
                                </div>
                            </div>

                            <?php
                            if (!empty($payment_category)) {
                                if ($payment_category == '1') {
                                    $balance_amount = str_replace(',', '', $reservation_price);
                                } elseif($payment_category == '2') {
                                    $balance_amount = str_replace(',', '', $reservation_price) - str_replace(',', '', $paying_amount);
                                }else{
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
<?php include '../footer.php'; ?>