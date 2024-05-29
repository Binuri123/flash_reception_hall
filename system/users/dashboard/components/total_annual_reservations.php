<div class="card bg-warning text-warning" style="--bs-bg-opacity: .05;">
    <div class="card-body text-center">
        <?php
        $db = dbConn();
        $year = date('Y');
        $sql = "SELECT count(*) as total_annual_reservations FROM reservation "
                . "WHERE YEAR(event_date) = '$year' AND reservation_status_id='5'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $total_annual_reservations = $row['total_annual_reservations'];
        ?>
        <h6># Reservations<br>(<?= $year ?>)<br><?= $total_annual_reservations ?></h6>
    </div>
</div>