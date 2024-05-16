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
                    <li class="breadcrumb-item active">Pending Reservations</li>
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
                $where = " AND $where";
            }
        }
        ?>
        <div class="row">
            <div class="col-md-1"></div>
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
                            <a href="<?= WEB_PATH ?>reservation/pending_reservations.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="table-responsive">
                    <table class="table table-striped bg-light">
                        <thead style="font-size:13px;text-align:center;vertical-align:middle;" class="bg-secondary text-white">
                            <tr style="vertical-align:middle">
                                <th>#</th>
                                <th>Reservation No</th>
                                <th>Event</th>
                                <th>Event Date</th>
                                <th>Reserved Hall</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th style="text-align:right;">Final Amount (Rs.)</th>
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
                                    . "LEFT JOIN event e ON e.event_id=r.event_id LEFT JOIN hall h ON h.hall_id=r.hall_id "
                                    . "WHERE r.customer_no=(SELECT customer_no FROM customer WHERE customer_id=".$_SESSION['customer_id'].") AND r.reservation_status_id = '1' $where";
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
                                        <td style="text-align:center;"><?= $row['start_time'] ?></td>
                                        <td style="text-align:center;"><?= $row['end_time'] ?></td>
                                        <td style="text-align:right;"><?= number_format($row['discounted_price'], '2', '.', ',') ?></td>
                                        <td>
                                            <a href="<?= WEB_PATH ?>payment/add.php?reservation_no=<?= $row['reservation_no'] ?>" class="btn btn-info btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-cash"></i></a>
                                        </td>
                                        <td>
                                            <a href="<?= WEB_PATH ?>reservation/cancel.php?reservation_no=<?= $row['reservation_no'] ?>" class="btn btn-danger btn-sm" style="text-align:center;vertical-align:middle;margin:0;padding:2px 5px;"><i class="bi bi-trash text-dark"></i></a>
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
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php include('../customer/footer.php') ?>