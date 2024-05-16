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
                <li class="breadcrumb-item active">Refunded Reservations</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped bg-light" style="font-size:13px;">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>Reservation No</th>
                                <th>Reservation Date</th>
                                <th>Reservation Status</th>
                                <th>Reservation Price(Rs.)</th>
                                <th>Canceled Date</th>
                                <th>Paid Amount(Rs.)</th>
                                <th>Refunded Amount(Rs.)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $db = dbConn();
                                $sql = "SELECT r.reservation_id,r.reservation_no,r.event_date,rr.refund_request_id,"
                                        . "r.discounted_price,rs.reservation_status,c.canceled_date,rr.paid_amount,rr.refundable_amount FROM reservation r "
                                        . "LEFT JOIN reservation_status rs ON r.reservation_status_id=rs.reservation_status_id "
                                        . "LEFT JOIN refund_request rr ON rr.reservation_no=r.reservation_no "
                                        . "LEFT JOIN canceled_reservations c ON c.reservation_no = r.reservation_no "
                                        . "WHERE r.customer_no=(SELECT customer_no FROM customer WHERE customer_id=".$_SESSION['customer_id'].") AND r.reservation_payment_status_id='4'";
                                //print_r($sql);
                                $result = $db->query($sql);
                                if($result->num_rows>0){
                                    while($row=$result->fetch_assoc()){
                            ?>
                            <tr style="font-size:13px;vertical-align:middle">
                                <td><?= $row['reservation_no'] ?></td>
                                <td><?= $row['event_date'] ?></td>
                                <td><?= $row['reservation_status'] ?></td>
                                <td><?= $row['discounted_price'] ?></td>
                                <td><?= $row['canceled_date'] ?></td>
                                <td><?= $row['paid_amount'] ?></td>
                                <td><?= $row['refundable_amount'] ?></td>
                                <td>
                                    <a href="<?=WEB_PATH?>refund/view.php?request_id=<?= $row['refund_request_id'] ?>" class="btn btn-info btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-eye-fill"></i></a>
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