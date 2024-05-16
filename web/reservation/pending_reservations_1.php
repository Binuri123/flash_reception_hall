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
                <li class="breadcrumb-item active">Pending Reservations</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped bg-light">
                        <thead style="font-size:13px;text-align:center;">
                            <tr>
                                <th>Reservation No</th>
                                <th>Event</th>
                                <th>Event Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Reservation Status</th>
                                <th>Final Amount (Rs.)</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM reservation r "
                                        . "LEFT JOIN reservation_status rs ON rs.reservation_status_id = r.reservation_status_id "
                                        . "LEFT JOIN event e ON e.event_id=r.event_id "
                                        . "WHERE (r.reservation_payment_status_id = '1' AND r.reservation_status_id = '1') "
                                        . "OR (r.reservation_payment_status_id = '6' AND r.reservation_status_id = '2') "
                                        . "OR (r.reservation_payment_status_id = '2' AND r.reservation_status_id = '2')";
                                //print_r($sql);
                                $result = $db->query($sql);
                                if($result->num_rows>0){
                                    while($row=$result->fetch_assoc()){
                            ?>
                            <tr style="font-size:13px;vertical-align:middle">
                                <td style="text-align:center;"><?= $row['reservation_no'] ?></td>
                                <td><?= $row['event_name'] ?></td>
                                <td style="text-align:center;"><?= $row['event_date'] ?></td>
                                <td style="text-align:center;"><?= $row['start_time'] ?></td>
                                <td style="text-align:center;"><?= $row['end_time'] ?></td>
                                <td><?= $row['reservation_status'] ?></td>
                                <td style="text-align:center;"><?= $row['discounted_price'] ?></td>
                                <td>
                                    <a href="<?=WEB_PATH?>reservation/edit.php?reservation_no=<?= $row['reservation_no'] ?>" class="btn btn-warning btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-pencil-square"></i></a>
                                </td>
                                <td>
                                    <a href="<?=WEB_PATH?>payment/add.php?reservation_no=<?= $row['reservation_no'] ?>" class="btn btn-info btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-cash"></i></a>
                                </td>
                                <td>
                                    <a href="<?=WEB_PATH?>reservation/cancel.php?reservation_no=<?= $row['reservation_no'] ?>" class="btn btn-danger btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-trash text-dark"></i></a>
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