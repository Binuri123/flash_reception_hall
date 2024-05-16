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
                <li class="breadcrumb-item"><a href="<?=WEB_PATH?>customer/dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?=WEB_PATH?>reservation/reservation.php">Reservation</a></li>
                <li class="breadcrumb-item active">Rejected Reservations</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped bg-light" style="font-size:13px;">
                        <thead>
                            <tr>
                                <th>Reservation No</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Reservation Status</th>
                                <th>Final Amount</th>
                                <th>Payment Status</th>
                                <th></th>
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
                                        . "WHERE customer_no=(SELECT customer_no FROM customer WHERE customer_id=".$_SESSION['customer_id'].") AND r.reservation_status_id='4'";
                                //print_r($sql);
                                $result = $db->query($sql);
                                if($result->num_rows>0){
                                    while($row=$result->fetch_assoc()){
                            ?>
                            <tr style="font-size:13px;vertical-align:middle">
                                <td><?= $row['reservation_no'] ?></td>
                                <td><?= $row['event_date'] ?></td>
                                <td><?= $row['start_time'] ?></td>
                                <td><?= $row['end_time'] ?></td>
                                <td><?= $row['reservation_status'] ?></td>
                                <td><?= $row['discounted_price'] ?></td>
                                <td><?= $row['payment_status'] ?></td>
                                <td>
                                    <a href="<?=WEB_PATH?>reservation/edit.php?reservation_id=<?= $row['reservation_id'] ?>" class="btn btn-warning btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-pencil-square"></i></a>
                                </td>
                                <td>
                                    <a href="<?=WEB_PATH?>reservation/view.php?reservation_id=<?= $row['reservation_id'] ?>" class="btn btn-info btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-eye-fill"></i></a>
                                </td>
                                <td>
                                    <a href="<?=WEB_PATH?>reservation/cancel.php?reservation_id=<?= $row['reservation_id'] ?>" class="btn btn-danger btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-x-lg"></i></a>
                                </td>
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