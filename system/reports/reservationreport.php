<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>reports/reportmenu.php">Reports</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reservation Report</li>
            </ol>
        </nav>
    </div>
    <?php
    $where = null;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
        // 3rd step- clean input
        $resno = cleanInput($resno);
        $cusname = cleanInput($cusname);
        $event = cleanInput($event);
        $guest = cleanInput($guest);
        $hall = cleanInput($hall);

        if (!empty($resno)) {
            $where .= " reservation_no LIKE '%$resno%' AND";
        }
        if (!empty($cusname)) {
            $where .= " first_name LIKE '%$cusname%' OR last_name LIKE '%$cusname%' AND";
        }
        if (!empty($regno)) {
            $where .= " c.customer_no LIKE '%$regno%' AND";
        }
        if (!empty($event)) {
            $where .= " r.event_id = '$event' AND";
        }
        if (!empty($resdatestart) && !empty($resdateend)) {
            $where .= " event_date BETWEEN '$resdatestart' AND '$resdateend' AND";
        }
        if (!empty($guest)) {
            $where .= " guest_count LIKE '%$guest%' AND";
        }
        if (!empty($hall)) {
            $where .= " h.hall_id = '$hall' AND";
        }
        if (!empty($status)) {
            $where .= " s.reservation_status_id = '$status' AND";
        }
        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = "WHERE $where";
        }
        $sql2 = "SELECT * FROM reservation r "
                . "LEFT JOIN event e ON e.event_id=r.event_id "
                . "LEFT JOIN hall h ON h.hall_id=r.hall_id "
                . "LEFT JOIN reservation_status s ON s.reservation_status_id=r.reservation_status_id "
                . "LEFT JOIN customer c ON c.customer_no=r.customer_no "
                . "LEFT JOIN customer_titles t ON t.title_id=c.title_id $where ";
        $db = dbConn();
        $result2 = $db->query($sql2);
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
        <div class="row mb-3">
            <div class="col">
                <input type="text" class="form-control" placeholder="Reservation No" name="resno" style="font-size:13px;">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Customer Name" name="cusname" style="font-size:13px;">
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Registration No" name="regno" style="font-size:13px;">
            </div>
            <div class="col">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM event";
                $result = $db->query($sql);
                ?>
                <select class="form-select" id="event" name="event" style="font-size:13px;">
                    <option value="">Select Event</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value=<?= $row['event_id']; ?> <?php if ($row['event_id'] == @$event) { ?>selected <?php } ?>><?= $row['event_name'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Guest" name="guest" style="font-size:13px;">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="date" class="form-control" placeholder="Date" name="resdatestart" style="font-size:13px;">
            </div>
            <div class="col">
                <input type="date" class="form-control" placeholder="Date" name="resdateend" style="font-size:13px;">
            </div>
            <div class="col">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM hall";
                $result = $db->query($sql);
                ?>
                <select class="form-select" id="hall" name="hall"  style="font-size:13px;">
                    <option value="">Select Hall</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value=<?= $row['hall_id']; ?> <?php if ($row['hall_id'] == @$hall) { ?>selected <?php } ?>><?= $row['hall_name'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col">
                <?php
                $db = dbConn();
                $sql = "SELECT * FROM reservation_status";
                $result = $db->query($sql);
                ?>
                <select class="form-select" id="status" name="status" style="font-size:13px;">
                    <option value="">Select Status</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value=<?= $row['reservation_status_id']; ?> <?php if ($row['reservation_status_id'] == @$status) { ?>selected <?php } ?>><?= $row['reservation_status'] ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-warning btn-sm"><i class="bi bi-search"> Search</i></button>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-sm" style="font-size:13px;">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Res No</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Customer Reg No</th>
                    <th scope="col">Event</th>
                    <th scope="col">Event Date</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Guest Count</th>
                    <th scope="col">Hall</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    if ($result2->num_rows > 0) {
                        while ($row = $result2->fetch_assoc()) {
                            ?>
                            <tr>
                                <td></td>
                                <td><?= $row['reservation_no'] ?></td>
                                <td><?= $row['title_name'] . " " . $row['first_name'] . " " . $row['last_name'] ?></td>
                                <td><?= $row['customer_no'] ?></td>
                                <td><?= $row['event_name'] ?></td>
                                <td><?= $row['event_date'] ?></td>
                                <td><?= $row['start_time'] ?></td>
                                <td><?= $row['end_time'] ?></td>  
                                <td><?= $row['guest_count'] ?></td>
                                <td><?= $row['hall_name'] ?></td>
                                <td><?= $row['reservation_status'] ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
<?php include '../footer.php'; ?> 