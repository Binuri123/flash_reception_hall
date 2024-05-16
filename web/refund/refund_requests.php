<?php
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main">
    <section>
        <div class="pagetitle">
            <h1>Refunds</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>refund/refund.php">Refunds</a></li>
                    <li class="breadcrumb-item active">Refund Requests</li>
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
                        <div class="col-md-4 mb-3">
                            <button type="submit" name="action" value="search" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"></i> Search</button>
                            <a href="<?= WEB_PATH ?>refund/refund_requests.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
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
                                <th>Reservation Price(Rs.)</th>
                                <th>Reservation Status</th>
                                <th>Canceled Date</th>
                                <th>Paid Amount(Rs.)</th>
                                <th>Refundable Amount(Rs.)</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT rr.refund_request_id,r.reservation_id,r.reservation_no,r.event_date,c.canceled_date,rr.requested_date,"
                                    . "r.discounted_price,rs.reservation_status,rps.payment_status,rr.paid_amount,refundable_amount FROM refund_request rr "
                                    . "LEFT JOIN reservation r ON rr.reservation_no=r.reservation_no "
                                    . "LEFT JOIN canceled_reservations c ON c.reservation_no = r.reservation_no "
                                    . "LEFT JOIN reservation_status rs ON r.reservation_status_id=rs.reservation_status_id "
                                    . "LEFT JOIN reservation_payment_status rps ON rps.payment_status_id=r.reservation_payment_status_id "
                                    . "WHERE rr.customer_no=(SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'] . ") "
                                    . "AND rr.refund_status_id='2' $where";
                            //print_r($sql);
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                $i = 1;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr style="font-size:13px;vertical-align:middle">
                                        <td style="text-align:center;"><?= $i ?></td>
                                        <td><?= $row['reservation_no'] ?></td>
                                        <td><?= $row['event_date'] ?></td>
                                        <td style="text-align:right;"><?= number_format($row['discounted_price'],'2','.',',') ?></td>
                                        <td><?= $row['reservation_status'] ?></td>
                                        <td><?= ($row['canceled_date']== NULL)? 'Rejected':$row['canceled_date'] ?></td>
                                        <td style="text-align:right;"><?= number_format($row['paid_amount'],'2','.',',') ?></td>
                                        <td style="text-align:right;"><?= number_format($row['refundable_amount'],'2','.',',') ?></td>
                                        <td>
                                            <a href="<?= WEB_PATH ?>refund/edit_reject_refund.php?request_id=<?= $row['refund_request_id'] ?>" class="btn btn-warning btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-pencil-square"></i></a>
                                        </td>
                                        <td>
                                            <a href="<?= WEB_PATH ?>refund/view.php?request_id=<?= $row['refund_request_id'] ?>" class="btn btn-info btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-eye-fill"></i></a>
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