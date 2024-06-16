<?php
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
                <li class="breadcrumb-item active" aria-current="page">Received</li>
            </ol>
        </nav>
    </div>
    <?php
    extract($_POST);
    //var_dump($_POST);
    $where = NULL;
    //echo 'outside';
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'search') {
        //echo 'inside';
        $customer_no = cleanInput($customer_no);
        $reservation_no = cleanInput($reservation_no);
        $min_date = cleanInput($min_date);
        $max_date = cleanInput($max_date);

        if (!empty($customer_no)) {
            //Wild card serach perform using like and %% signs
            $where .= " cp.customer_no LIKE '%$customer_no%' AND";
        }

        if (!empty($reservation_no)) {
            //echo 'inside';
            //Wild card serach perform using like and %% signs
            $where .= " cp.reservation_no LIKE '%$reservation_no%' AND";
        }
        if (!empty($payment_category)) {
            //Wild card serach perform using like and %% signs
            $where .= " cp.payment_category_id = '$payment_category' AND";
        }

        if (!empty($min_date) && !empty($max_date)) {
            $where .= " r.paid_date BETWEEN '$min_date' AND '$max_date' AND";
        } elseif (!empty($min_date) && empty($max_date)) {
            $where .= " r.paid_date = '$min_date' AND";
        } elseif (empty($min_date) && !empty($max_date)) {
            $where .= " r.paid_date = '$max_date' AND";
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " AND $where";
        }
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row mb-3 align-items-end">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Receipt No" name="receipt_no" value="<?= @$receipt_no ?>" style="font-size:13px;font-style:italic;">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Customer No" name="customer_no" value="<?= @$customer_no ?>" style="font-size:13px;font-style:italic;">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Reservation No" name="reservation_no" value="<?= @$reservation_no ?>" style="font-size:13px;font-style:italic;">
                    </div>
                    <div class="col">
                        <?php
                        $db = dbConn();
                        $sql2 = "SELECT * FROM payment_category";
                        $result2 = $db->query($sql2);
                        ?>
                        <select name="payment_category" class="form-control form-select" style="font-size:13px;font-style:italic;">
                            <option value="" style="text-align:center">-Payment Category-</option>
                            <?php
                            if ($result2->num_rows > 0) {
                                while ($row2 = $result2->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row2['payment_category_id'] ?>" <?php if ($row2['payment_category_id'] == @$payment_category) { ?> selected <?php } ?>><?= $row2['payment_category_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <?php
                        $db = dbConn();
                        $sql2 = "SELECT * FROM payment_method WHERE method_id != '1'";
                        $result2 = $db->query($sql2);
                        ?>
                        <select name="payment_method" class="form-control form-select" style="font-size:13px;font-style:italic;">
                            <option value="" style="text-align:center">-Payment Method-</option>
                            <?php
                            if ($result2->num_rows > 0) {
                                while ($row2 = $result2->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row2['method_id'] ?>" <?php if ($row2['method_id'] == @$payment_method) { ?> selected <?php } ?>><?= $row2['method_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3 align-items-end">
                    <div class="col">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:13px;font-style:italic;">Paid Date</label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:13px;font-style:italic;">Paid Amount</label>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="date" class="form-control" name="min_date" value="<?= @$min_date ?>" style="font-size:13px;font-style:italic;">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="date" class="form-control" name="max_date" value="<?= @$max_date ?>" style="font-size:13px;font-style:italic;">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Min Amount" name="min_amount" value="<?= @$min_amount ?>" style="font-size:13px;font-style:italic;">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Max Amount" name="max_amount" value="<?= @$max_amount ?>" style="font-size:13px;font-style:italic;">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" name="action" value="search" class="btn btn-warning btn-sm flex-grow-1" style="font-size:13px;font-style:italic;"><i class="bi bi-search"></i> Search</button>
                                <a href="<?= SYSTEM_PATH ?>customer_payment/received.php" class="btn btn-info btn-sm flex-grow-1 ms-2" style="font-size:13px;font-style:italic;"><i class="bi bi-eraser"></i> Clear</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table modified table-striped table-sm" style="font-size:13px;">
                    <thead class="bg-secondary text-white" style="font-size:13px;vertical-align: middle;text-align:center;">
                        <tr>
                            <th>#</th>
                            <th scope="col">Receipt No</th>
                            <th scope="col">Reservation NO</th>
                            <th scope="col">Customer No</th>
                            <th scope="col">Paid Date</th>
                            <th scope="col">Paid Amount (Rs.)</th>
                            <th scope="col">Payment Category</th>
                            <th scope="col">Payment Method</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '4') {
                                ?>
                                <th scope="col">Pay Slip</th>
                                <?php
                            }
                            ?>
                                <th scope="col"></th>
                                <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(hasRole(4)) {
                            $sql = "SELECT * FROM customer_payments cp "
                                    . "LEFT JOIN payment_category pc ON pc.payment_category_id=cp.payment_category_id "
                                    . "LEFT JOIN payment_method pm ON pm.method_id = cp.payment_method_id "
                                    . "WHERE cp.payment_status = '1' AND cp.payment_method_id != '1' $where ORDER BY cp.add_date DESC";
                        }elseif(hasAnyRole([1,2,6])){
                            $sql = "SELECT * FROM customer_payments cp "
                                    . "LEFT JOIN payment_category pc ON pc.payment_category_id=cp.payment_category_id "
                                    . "LEFT JOIN payment_method pm ON pm.method_id = cp.payment_method_id "
                                    . "WHERE cp.payment_status = '1' $where ORDER BY cp.add_date DESC";
                        }
                        //print_r($sql);
                        $db = dbConn();
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr style="vertical-align:middle;">
                                    <td><?= $i ?></td>
                                    <td><?= $row['receipt_no'] ?></td>
                                    <td><?= $row['reservation_no'] ?></td>
                                    <td><?= $row['customer_no'] ?></td>
                                    <td><?= $row['paid_date'] ?></td>
                                    <td><?= number_format($row['paid_amount'],'2','.',',') ?></td>
                                    <td><?= $row['payment_category_name'] ?></td>
                                    <td><?= $row['method_name'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '4') {
                                        ?>
                                        <td>
                                            <img src="../../web/assets/img/pay_slip/customer/<?= $row['pay_slip'] ?>" style="width:60px;height:60px;">
                                        </td>
                                        <?php
                                    }
                                    ?>
                                    <td><a href="verification.php?payment_id=<?= $row['payment_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-check-circle-fill"></i></a></td>
                                    <td><a href="<?= SYSTEM_PATH ?>customer_payment/view.php?payment_id=<?= $row['payment_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include '../footer.php'; ?>
