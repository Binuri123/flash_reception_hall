<?php
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main">
    <section>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            extract($_GET);
            $db = dbConn();
            $sql = "SELECT r.reservation_no,r.event_id,r.event_date,r.function_mode,r.start_time,r.end_time,r.guest_count,r.hall_id,"
                    . "r.reservation_status_id,r.discounted_price,r.reservation_payment_status_id,r.add_date,r."
                    . "add_time,cr.cancel_reason,cr.canceled_date,cr.cancel_time FROM reservation r "
                    . "LEFT JOIN canceled_reservations cr ON cr.reservation_no=r.reservation_no "
                    . "WHERE r.reservation_no = '$reservation_no'";
            //print_r($sql);
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
        }
        ?>
        <div class="pagetitle">
            <h1>Reservation</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>reservation/reservation.php">Reservation</a></li>
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>reservation/cancel.php?reservation_no =<?= $reservation_no ?>">Cancel Reservation</a></li>
                    <li class="breadcrumb-item active">Cancel Success</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <div class="card bg-success-light">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mt-3 mb-3" style="text-align:center;">
                        <h4>Reservation Successfully Canceled...!!!</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 mt-3 mb-3" style="text-align:center;">
                        <div class="table-responsive">
                            <table class="table table-striped table-success table-bordered" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th colspan="2">Cancellation Details</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align:left;">
                                    <tr>
                                        <td>Reservation No</td>
                                        <td><?= $row['reservation_no'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Event</td>
                                        <?php
                                        $sql_event = "SELECT event_name FROM event WHERE event_id=".$row['event_id'];
                                        //print_r($sql_event);
                                        $result_event = $db->query($sql_event);
                                        $row_event = $result_event->fetch_assoc();
                                        ?>
                                        <td><?= $row_event['event_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Event Date</td>
                                        <td><?= $row['event_date'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Function Mode</td>
                                        <td><?= $row['function_mode'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Time</td>
                                        <td><?= $row['start_time'] . '-' . $row['end_time'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Guest Count</td>
                                        <td><?= $row['guest_count'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Hall</td>
                                        <?php
                                        $sql_hall = "SELECT hall_name FROM hall WHERE hall_id=" . $row['hall_id'];
                                        $result_hall = $db->query($sql_hall);
                                        $row_hall = $result_hall->fetch_assoc();
                                        ?>
                                        <td><?= $row_hall['hall_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Reservation Status</td>
                                        <?php
                                        $sql_res_status = "SELECT reservation_status FROM reservation_status WHERE reservation_status_id=" . $row['reservation_status_id'];
                                        $result_res_status = $db->query($sql_res_status);
                                        $row_res_status = $result_res_status->fetch_assoc();
                                        ?>
                                        <td><?= $row_res_status['reservation_status'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Final Reservation Price (Rs.)</td>
                                        <?php
                                        $discounted_price = number_format($row['discounted_price'], '2', '.', ',');
                                        ?>
                                        <td><?= $discounted_price ?></td>
                                    </tr>
                                    <tr>
                                        <td>Reservation Payment Status</td>
                                        <?php
                                        $sql_res_status = "SELECT payment_status FROM reservation_payment_status WHERE payment_status_id=" . $row['reservation_payment_status_id'];
                                        $result_res_status = $db->query($sql_res_status);
                                        $row_res_status = $result_res_status->fetch_assoc();
                                        ?>
                                        <td><?= $row_res_status['payment_status'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Canceled Date</td>
                                        <td><?= $row['canceled_date'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Reason of Cancellation</td>
                                        <td><?= $row['cancel_reason'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row" style="font-size:13px;">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <p><strong><i>Your Reservation Has Successfully Canceled.<a href="<?= WEB_PATH ?>business_policies/terms_and_conditions.php" style="text-decoration:underline">Terms and Conditions</a></i></strong></p>
                        <p><strong><i><a href="<?= WEB_PATH ?>reservation/reservation_history.php" style="text-decoration:underline">Reservation History</a></i></strong></p>
                        <?php
                        $res_add_date = $row['add_date'];
                        $res_add_time = $row['add_time'];
                        $cancel_date = $row['canceled_date'];
                        $cancel_time = $row['cancel_time'];

                        $res_time = date('Y-m-d H:i', strtotime("$res_add_date $res_add_time"));
                        $cancel_time = date('Y-m-d H:i', strtotime("$cancel_date $cancel_time"));
                        $start = new DateTime($res_time);
                        $end = new DateTime($cancel_time);
                        $diff = $start->diff($end);
                        $diff_hours = $diff->h;

                        $db = dbConn();
                        $sql_payments = "SELECT payment_category_id FROM customer_payment WHERE reservation_no='$reservation_no'";
                        $result_payments = $db->query($sql_payments);
                        if ($diff_hours > 4) {
                            $row = $result->fetch_assoc();
                            //var_dump($row);
                        }
                        ?>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include '../customer/footer.php';
?>