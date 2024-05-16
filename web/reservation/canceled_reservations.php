<?php
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main">
    <section>
        <div class="pagetitle">
            <h1>Reservation</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>reservation/reservation.php">Reservations</a></li>
                    <li class="breadcrumb-item active">Canceled Reservations</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <?php
        $where = null;
        extract($_POST);
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'search') {
            $reservation_no = cleanInput($reservation_no);

            if (!empty($reservation_no)) {
                $where .= " r.reservation_no LIKE '%$reservation_no%' AND";
            }

            if (!empty($event)) {
                $where .= " r.event_id = '$event' AND";
            }

            if (!empty($hall)) {
                $where .= " r.hall_id = '$hall' AND";
            }

            if (!empty($reservation_status)) {
                $where .= " r.reservation_status_id = '$reservation_status' AND";
            }

            if (!empty($payment_status)) {
                $where .= " r.reservation_payment_status_id = '$payment_status' AND";
            }

            if (!empty($start_date) && !empty($end_date)) {
                $where .= " r.event_date BETWEEN '$start_date' AND '$end_date' AND";
            } elseif (!empty($start_date) && empty($end_date)) {
                $where .= " r.event_date = '$start_date' AND";
            } elseif (empty($start_date) && !empty($end_date)) {
                $where .= " r.event_date = '$end_date' AND";
            }

            if (!empty($where)) {
                $where = substr($where, 0, -3);
                $where = "AND $where";
            }
        }
        ?>
        <div class="row">
            <div class="col-md-10">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <input type="text" name="reservation_no" value="<?= @$reservation_no ?>" placeholder="Reservation No" style="font-size:13px;" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM event";
                            $result = $db->query($sql);
                            ?>
                            <select name="event" class="form-control form-select" style="font-size:13px;">
                                <option value="" style="text-align:center">-Event-</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['event_id'] ?>" <?php if ($row['event_id'] == @$event) { ?> selected <?php } ?>><?= $row['event_name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM hall";
                            $result = $db->query($sql);
                            ?>
                            <select name="hall" class="form-control form-select" style="font-size:13px;">
                                <option value="" style="text-align:center">-Hall-</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['hall_id'] ?>" <?php if ($row['hall_id'] == @$hall) { ?> selected <?php } ?>><?= $row['hall_name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM reservation_payment_status WHERE payment_status_id != '4' AND payment_status_id != '5'";
                            $result = $db->query($sql);
                            ?>
                            <select name="payment_status" class="form-control form-select" style="font-size:13px;">
                                <option value="" style="text-align:center">-Payment Status-</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['payment_status_id'] ?>" <?php if ($row['payment_status_id'] == @$payment_status) { ?> selected <?php } ?>><?= $row['payment_status'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="row">
                                <div class='col-md-4'>
                                    <label class="form-label" style="font-size:13px;">Start Date</label>
                                </div>
                                <div class='col-md-8'>
                                    <input type="date" name="start_date" value="<?= @$start_date ?>" placeholder="Start Date" style="font-size:13px;" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="row">
                                <div class='col-md-4'>
                                    <label class="form-label" style="font-size:13px;">End Date</label>
                                </div>
                                <div class='col-md-8'>
                                    <input type="date" name="end_date" value="<?= @$end_date ?>" placeholder="End Date" style="font-size:13px;" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"></i> Search</button>
                            <a href="<?= WEB_PATH ?>reservation/canceled_reservations.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped bg-light" style="font-size:13px;text-align:center;">
                        <thead style="font-size:13px;text-align:center;vertical-align:middle;" class="bg-secondary text-white">
                            <tr style="vertical-align:middle">
                                <th>#</th>
                                <th>Reservation No</th>
                                <th>Event Date</th>
                                <th>Event Time</th>
                                <th>Reservation Status</th>
                                <th style="text-align:left;">Canceled Reason</th>
                                <th>Final Amount</th>
                                <th>Paid Amount</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT r.reservation_id,r.reservation_no,r.event_date,r.start_time,r.end_time,"
                                    . "r.discounted_price,rs.reservation_status,rps.payment_status FROM reservation r "
                                    . "LEFT JOIN reservation_status rs ON r.reservation_status_id=rs.reservation_status_id "
                                    . "LEFT JOIN reservation_payment_status rps ON rps.payment_status_id=r.reservation_payment_status_id "
                                    . "WHERE customer_no=(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ") "
                                    . "AND r.reservation_status_id='3' "
                                    . "AND r.reservation_no NOT IN (SELECT reservation_no FROM refund_request) $where";
                            //print_r($sql);
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $i=1;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr style="font-size:13px;vertical-align:middle">
                                        <td style="text-align:center;"><?= $i ?></td>
                                        <td><?= $row['reservation_no'] ?></td>
                                        <td><?= $row['event_date'] ?></td>
                                        <td><?= $row['start_time'] . " - " . $row['end_time'] ?></td>
                                        <td><?= $row['payment_status'] ?></td>
                                        <?php
                                        $sql_cancel_reason = "SELECT cancel_reason FROM canceled_reservations WHERE reservation_no = '" . $row['reservation_no'] . "'";
                                        $result_cancel_reason = $db->query($sql_cancel_reason);
                                        $row_cancel_reason = $result_cancel_reason->fetch_assoc();
                                        ?>
                                        <td style="text-align:left;"><?= $row_cancel_reason['cancel_reason'] ?></td>
                                        <td style="text-align:right;"><?= number_format($row['discounted_price'],'2','.',',') ?></td>
                                        <?php
                                        $sql_paid_amount = "SELECT SUM(paid_amount) as total_paid FROM customer_payments WHERE reservation_no ='" . $row['reservation_no'] . "' AND payment_status = '2'";
                                        //print_r($sql_paid_amount);
                                        $result_paid_amount = $db->query($sql_paid_amount);
                                        $row_paid_amount = $result_paid_amount->fetch_assoc();
                                        if ($row_paid_amount['total_paid'] == NULL) {
                                            $paid_amount = '-';
                                        } else {
                                            $paid_amount = number_format($row_paid_amount['total_paid'], '2', '.', ',');
                                        }
                                        ?>
                                        <td style="text-align:right;"><?= $paid_amount ?></td>
                                        <td>
                                            <a href="<?= WEB_PATH ?>reservation/view.php?reservation_id=<?= $row['reservation_id'] ?>" class="btn btn-info btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-eye-fill"></i></a>
                                        </td>
                                        <?php
                                        $sql_paid = "SELECT COUNT(*) as payments FROM customer_payments WHERE reservation_no ='" . $row['reservation_no'] . "' AND payment_status = '2'";
                                        $result_paid = $db->query($sql_paid);
                                        $row_paid = $result_paid->fetch_assoc();
                                        if ($row_paid['payments'] > 0) {
                                            $sql_add_time = "SELECT add_date,add_time FROM reservation WHERE reservation_no ='" . $row['reservation_no'] . "'";
                                            $result_add_time = $db->query($sql_add_time);
                                            $row_add_time = $result_add_time->fetch_assoc();
                                            //var_dump($row_add_time);
                                            $add_time = $row_add_time['add_date'] . ' ' . $row_add_time['add_time'];
                                            $sql_cancel_time = "SELECT canceled_date,cancel_time FROM canceled_reservations WHERE reservation_no ='" . $row['reservation_no'] . "'";
                                            $result_cancel_time = $db->query($sql_cancel_time);
                                            $row_cancel_time = $result_cancel_time->fetch_assoc();
                                            //var_dump($row_cancel_time);
                                            $cancel_time = $row_cancel_time['canceled_date'] . ' ' . $row_cancel_time['cancel_time'];
                                            $added_time = new DateTime($add_time);
                                            $canceled_time = new DateTime($cancel_time);
                                            $time_difference = $canceled_time->diff($added_time);
                                            //var_dump($time_difference);
                                            $timeDifferenceInHours = $time_difference->days * 24 + $time_difference->h + ($time_difference->i / 60) + ($time_difference->s / 3600);
                                            //var_dump($timeDifferenceInHours);
                                            $sql_made_payments = "SELECT MAX(payment_category_id) as last_payment FROM customer_payments WHERE reservation_no='" . $row['reservation_no'] . "' "
                                                    . "AND (payment_status = '2' OR payment_status = '4')";
                                            $result_made_payments = $db->query($sql_made_payments);
                                            $row_made_payments = $result_made_payments->fetch_assoc();
                                            //var_dump($row_made_payments);
                                            $last_payment = $row_made_payments['last_payment'];
                                            if ($timeDifferenceInHours > (float) 4) {
                                                if ($last_payment == '1') {
                                                    ?>
                                                    <td>No Refund</td>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <td>
                                                        <a href ="<?= WEB_PATH ?>refund/refund_request.php?reservation_no=<?= $row['reservation_no'] ?>" class = "btn btn-danger btn-sm" style = "text-align:center;vertical-align:middle;margin:0;padding:2px 5px;">Request Refund</a>
                                                    </td> 
                                                    <?php
                                                }
                                            } elseif ($timeDifferenceInHours <= (float) 4) {
                                                ?>
                                                <td>
                                                    <a href ="<?= WEB_PATH ?>refund/refund_request.php?reservation_no=<?= $row['reservation_no'] ?>" class = "btn btn-danger btn-sm" style = "text-align:center;vertical-align:middle;margin:0;padding:2px 5px;">Request Refund</a>
                                                </td>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <td>No Refund</td>
                                            <?php
                                        }
                                        ?>
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
    </section>
</main>
<?php include('../customer/footer.php') ?>