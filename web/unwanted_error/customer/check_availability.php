<?php
include 'header.php';
include 'sidebar.php';

//Checking the Request Method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);

    $event_date = cleanInput($event_date);
    $start_time = cleanInput($start_time);
    $end_time = cleanInput($end_time);
    $guest_count = cleanInput($guest_count);

    $message = array();
    //Required Field Validation
    if (empty($event)) {
        $message['error_event'] = 'An Event Should be Selected';
    }

    if (empty($event_date)) {
        $message['error_event_date'] = 'The Event Date Should be Selected';
    }

    if (empty($start_time)) {
        $message['error_start_time'] = 'A Start Time Should be Selected';
    }

    if (empty($end_time)) {
        $message['error_end_time'] = 'A End Time Should be Selected';
    }

    if (empty($guest_count)) {
        $message['error_guest_count'] = 'Your Guest Count Should be Entered';
    }

    if (empty($hall)) {
        $message['error_hall'] = 'A Hall Should be Selected';
    }

    if (!empty($message)) {
        $db = dbConn();
        //Get the available hall ids
        $sql = "SELECT * FROM hall WHERE availability ='Available' "
                . "AND IN (SELECT hall_id FROM hall_event WHERE event_id='$event') "
                . "AND min_capacity<='$guest_count' AND max_capacity>='$guest_count' "
                . "AND NOT IN (SELECT hall_id FROM reservation WHERE date = $event_date AND status_id = 2 "
                . "AND (start_time ='$start_time' OR end_time = '$start_time' OR start_time = '$end_time' "
                . "OR end_time = '$end_time' "
                . "OR (end_time BETWEEN '$start_time' AND '$end_time') "
                . "OR (start_time<'$start_time' AND end_time>'$end_time'))";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <a href="<?= WEB_PATH ?>reservation/event_details.php"><?= $row['hall_name'] ?></a>
                <?php
            }
        } else {
            echo 'Sorry The date and time you are looking for is not available';
        }
    }
}
?>
<main id="main">
    <section>
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="row mt-3 mb-3">
                        <div class="col-md-6">
                            <label for="event" class="form-label">Event</label>
                            <select id="event" name="event" class="form-control form-select">
                                <option value="">Select a Event</option>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM event";
                                $result = $db->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value=<?= $row['event_id']; ?> <?php if ($row['event_id'] == @$event) { ?> selected <?php } ?>><?= $row['event_name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="text-danger"><?= @$message["error_event"] ?></div>
                        </div>
                        <div class="col-md-6">
                            <?php
                            $today = date('Y-m-d');
                            $mindate = date('Y-m-d', strtotime('+14 days', strtotime($today)));
                            $maxdate = date('Y-m-d', strtotime('+1 year', strtotime($today)));
                            ?>
                            <label for="event_date" class="form-label">Event Date</label>
                            <input type="date" min="<?= $mindate ?>" max="<?= $maxdate ?>" class="form-control" placeholder="Pick a Date" id="event_date" name="event_date" value="<?= @$event_date ?>">
                            <div class="text-danger"><?= @$message["error_event_date"] ?></div>
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-md-6">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" min="07:00 AM" max="12:00 AM" class="form-control" placeholder="Pick a Date" id="start_time" name="start_time" value="<?= @$start_time ?>">
                            <div class="text-danger"><?= @$message["error_start_time"] ?></div>
                        </div>
                        <div class="col-md-6">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" min="07:00 AM" max="12:00 AM" class="form-control" placeholder="Pick a Date" id="end_time" name="end_time" value="<?= @$end_time ?>">
                            <div class="text-danger"><?= @$message["error_end_time"] ?></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="guest_count" class="form-label">Guest Count</label>
                            <input type="number" name="guest_count" id="guest_count" class="form-control" value="<?= @$guest_count ?>">
                            <div class="text-danger"><?= @$message["error_guest_count"] ?></div>
                        </div>
                        <div class="col-md-6">
                            <label for="hall" class="form-label">Hall</label>
                            <select id="hall" name="hall" class="form-control">
                                <option value="">Select a Hall</option>
                                <?php
                                if(!empty($event)){
                                    $hall_id = "SELECT hall_id FROM hall_event WHERE event_id = '$event'";
                                }
                                $db = dbConn();
                                $sql = "SELECT * FROM hall";
                                $result = $db->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value=<?= $row['hall_id']; ?> <?php if ($row['hall_id'] == @$hall) { ?> selected <?php } ?>><?= $row['hall_name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="text-danger"><?= @$message["error_hall"] ?></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12" style="text-align:right">
                            <button type="reset" class="btn btn-warning">Cancel</button>
                            <button type="submit" class="btn btn-success">Check</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>