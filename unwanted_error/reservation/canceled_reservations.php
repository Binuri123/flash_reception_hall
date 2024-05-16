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
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>reservation/reservation.php">Reservation</a></li>
                    <li class="breadcrumb-item active">Canceled Reservations</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped bg-light" style="font-size:13px;text-align:center;">
                        <thead>
                            <tr>
                                <th>Reservation No</th>
                                <th>Event Date</th>
                                <th>Event Time</th>
                                <th>Reservation Status</th>
                                <th>Canceled Reason</th>
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
                                    . "AND r.reservation_status_id='3'";
                            //print_r($sql);
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr style="font-size:13px;vertical-align:middle">
                                        <td><?= $row['reservation_no'] ?></td>
                                        <td><?= $row['event_date'] ?></td>
                                        <td><?= $row['start_time'] . " - " . $row['end_time'] ?></td>
                                        <td><?= $row['reservation_status'] ?></td>
                                        <?php
                                        $sql_cancel_reason = "SELECT cancel_reason FROM canceled_reservations WHERE reservation_no = '".$row['reservation_no']."'";
                                        $result_cancel_reason = $db->query($sql_cancel_reason);
                                        $row_cancel_reason = $result_cancel_reason->fetch_assoc();
                                        ?>
                                        <td><?= $row_cancel_reason['cancel_reason'] ?></td>
                                        <td><?= $row['discounted_price'] ?></td>
                                        <?php
                                           $sql_paid_amount = "SELECT SUM(paid_amount) as total_paid FROM customer_payments WHERE reservation_no ='".$row['reservation_no']."' AND payment_status = '2'";
                                           print_r($sql_paid_amount);
                                           $result_paid_amount = $db->query($sql_paid_amount);
                                           $row_paid_amount = $result_paid_amount->fetch_assoc();
                                           if($row_paid_amount['total_paid'] == NULL){
                                               $paid_amount = '-';
                                           }else{
                                               $paid_amount = number_format($row_paid_amount['total_paid'],'2','.',',');
                                           }
                                        ?>
                                        <td><?= $paid_amount ?></td>
                                        <td>
                                            <a href="<?= WEB_PATH ?>reservation/view.php?reservation_id=<?= $row['reservation_id'] ?>" class="btn btn-info btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-eye-fill"></i></a>
                                        </td>
                                        <?php
                                        $sql_paid = "SELECT COUNT(*) FROM customer_payment WHERE reservation_no =" . $row['reservation_no'] . " AND payment_status = '2'";
                                        $result_paid = $db->query($sql_paid);
                                        if ($result->num_rows > 0) {
                                            ?>
                                            <td>
                                                <a href ="<?= WEB_PATH ?>refund/refund_request.php?reservation_no=<?= $row['reservation_no'] ?>" class = "btn btn-danger btn-sm" style = "text-align:center;vertical-align:middle;margin:0;padding:2px 5px;">Request Refund</a>
                                            </td>
                                            <?php
                                        }else{
                                            ?>
                                            <td>No Refund</td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
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