<?php
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main">
    <section>
        <div class="pagetitle">
            <div class="row">
                <div class="col-md-6">
                    <h1>Arrangements</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Arrangements</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6" style="text-align:right">
                    <a href="<?= WEB_PATH ?>reservation/confirmed_reservations.php" class="btn btn-info-light btn-outline-success btn-sm" style="font-size:13px;"><i class="bi bi-plus-circle"></i> Request Arrangement Plan</a>
                </div>
            </div>
        </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped bg-light" style="font-size:13px;">
                        <thead style="font-size:13px;text-align:center;vertical-align:middle;" class="bg-secondary text-white">
                            <tr style="vertical-align:middle">
                                <th>#</th>
                                <th>Reservation No</th>
                                <th>Event</th>
                                <th>Event Date</th>
                                <th>Reserved Hall</th>
                                <th>Reservation Status</th>
                                <th>Arrangement Plan Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT ap.arrangement_plan_id,r.reservation_id,r.reservation_no,e.event_name,r.event_date,h.hall_name,r.start_time,r.end_time,"
                                    . "r.discounted_price,rs.reservation_status,rps.payment_status,aps.arr_plan_status FROM reservation r "
                                    . "LEFT JOIN reservation_status rs ON r.reservation_status_id=rs.reservation_status_id "
                                    . "LEFT JOIN reservation_payment_status rps ON rps.payment_status_id=r.reservation_payment_status_id "
                                    . "LEFT JOIN event e ON e.event_id=r.event_id LEFT JOIN hall h ON h.hall_id=r.hall_id "
                                    . "INNER JOIN arrangement_plan ap ON ap.reservation_no=r.reservation_no "
                                    . "INNER JOIN arrangement_plan_status aps ON aps.arr_plan_status_id=ap.arrangement_status_id "
                                    . "WHERE r.customer_no=(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ")";
                            //print_r($sql);
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $i = 1;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr style="font-size:13px;vertical-align:middle">
                                        <td style="text-align:center;"><?= $i ?></td>
                                        <td style="text-align:center;"><?= $row['reservation_no'] ?></td>
                                        <td><?= $row['event_name'] ?></td>
                                        <td style="text-align:center;"><?= $row['event_date'] ?></td>
                                        <td><?= $row['hall_name'] ?></td>
                                        <td style="text-align:center;"><?= $row['reservation_status'] ?></td>
                                        <td style="text-align:center;"><?= $row['arr_plan_status'] ?></td>
                                        <td>
                                            <a href="<?= WEB_PATH ?>arrangement_plan/view.php?arr_plan_id=<?= $row['arrangement_plan_id'] ?>" class="btn btn-info btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-eye-fill"></i></a>
                                        </td>
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