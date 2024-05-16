<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Refunds</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>refund/refund_request.php" style="text-decoration:none;color:white">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as refund_requests FROM refund_request WHERE refund_status_id='2'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $refund_requests = $row['refund_requests'];
                            ?>
                            <h4># Requests<br><?= $refund_requests ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>refund/refund_approved.php" style="text-decoration:none;color:white">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as refund_approved FROM refund_request WHERE refund_status_id='4'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $refund_approved = $row['refund_approved'];
                            ?>
                            <h4># Approved<br><?= $refund_approved ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>refund/refund_pending.php" style="text-decoration:none;color:white">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as refund_pending FROM refund_request WHERE refund_status_id='3'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $refund_pending = $row['refund_pending'];
                            ?>
                            <h4># Pending<br><?= $refund_pending ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>refund/refund_issued.php" style="text-decoration:none;color:white">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as refund_issued FROM refund_request WHERE refund_status_id='5'";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $refund_issued = $row['refund_issued'];
                            ?>
                            <h4># Refunded<br><?= $refund_issued ?></h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
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
                    $min_price = cleanInput($min_price);
                    $max_price = cleanInput($max_price);

                    if (!empty($customer_no)) {
                        //Wild card serach perform using like and %% signs
                        $where .= " r.customer_no LIKE '%$customer_no%' AND";
                    }

                    if (!empty($reservation_no)) {
                        //Wild card serach perform using like and %% signs
                        $where .= " r.reservation_no LIKE '%$reservation_no%' AND";
                    }

                    if (!empty($min_date) && !empty($max_date)) {
                        $where .= " r.event_date BETWEEN '$min_date' AND '$max_date' AND";
                    } elseif (!empty($min_date) && empty($max_date)) {
                        $where .= " r.event_date = '$min_date' AND";
                    } elseif (empty($min_date) && !empty($max_date)) {
                        $where .= " r.event_date = '$max_date' AND";
                    }

                    if (!empty($min_price) && !empty($max_price)) {
                        $where .= " r.discounted_price BETWEEN '$min_price' AND '$max_price' AND";
                    } elseif (!empty($min_price) && empty($max_price)) {
                        $where .= " r.discounted_price >= '$min_price' AND";
                    } elseif (empty($min_price) && !empty($max_price)) {
                        $where .= " r.discounted_price <= '$max_price' AND";
                    }

                    if (!empty($where)) {
                        $where = substr($where, 0, -3);
                        $where = " WHERE $where";
                    }
                }
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <h3>Refund List</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <input type="text" class="form-control" placeholder="Customer No" name="customer_no" value="<?= @$customer_no ?>" style="font-size:13px;">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <input type="text" class="form-control" placeholder="Reservation No" name="reservation_no" value="<?= @$reservation_no ?>" style="font-size:13px;">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <input type="date" class="form-control" name="min_date" value="<?= @$min_date ?>" style="font-size:13px;">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <input type="date" class="form-control" name="max_date" value="<?= @$max_date ?>" style="font-size:13px;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <input type="text" class="form-control" placeholder="Min Price" name="min_price" value="<?= @$min_price ?>" style="font-size:13px;">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <input type="text" class="form-control" placeholder="Max Price" name="max_price" value="<?= @$max_price ?>" style="font-size:13px;">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"></i> Search</button>
                                    <a href="<?= SYSTEM_PATH ?>refund/refund.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" style="font-size:13px;vertical-align: middle;text-align:center;">
                                <thead class="bg-secondary">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Customer No</th>
                                        <th scope="col">Reservation No</th>
                                        <th scope="col">Reservation Date</th>
                                        <th scope="col">Canceled Date</th>
                                        <th scope="col">Paid Amount (Rs.)</th>
                                        <th scope="col">Refundable Amount (Rs.)</th>
                                        <th scope="col">Refund Method</th>
                                        <th scope="col">Refund Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT rr.reservation_no,rr.customer_no,r.event_date,c.canceled_date,rr.paid_amount,rr.refundable_amount,s.refund_status_name,m.method_name FROM refund_request rr "
                                            . "LEFT JOIN refund_status s ON s.refund_status_id=rr.refund_status_id "
                                            . "LEFT JOIN payment_method m ON m.method_id=rr.refund_method_id "
                                            . "LEFT JOIN reservation r ON r.reservation_no=rr.reservation_no "
                                            . "LEFT JOIN canceled_reservations c ON c.reservation_no=r.reservation_no "
                                            . "$where ORDER BY rr.refund_request_id ASC";
                                    //print_r($sql);
                                    $db = dbConn();
                                    $result = $db->query($sql);
                                    if ($result->num_rows > 0) {
                                        $i = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $row['customer_no'] ?></td>
                                                <td><?= $row['reservation_no'] ?></td>
                                                <td><?= $row['event_date'] ?></td>
                                                <td><?= $row['canceled_date'] ?></td>
                                                <td style="text-align:right;"><?= number_format($row['paid_amount'],'2','.',',') ?></td>
                                                <td style="text-align:right;"><?= number_format($row['refundable_amount'],'2','.',',') ?></td>
                                                <td style="text-align:left;"><?= $row['method_name'] ?></td>
                                                <td><?= $row['refund_status_name'] ?></td>
                                                <td style="text-align:center;"><a href="<?=SYSTEM_PATH?>refund/view.php?reservation_no=<?= $row['reservation_no'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
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
            </div>
        </div>
    </div>
</main>

<?php include '../footer.php'; ?>
