<?php
include 'header.php';
extract($_POST);
?>

<main id="main">
    <section>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h3>Make a Reservation</h3>
                </div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="event" class="form-label"><span class="text-danger">* </span>Event</label>
                        </div>
                        <div class="col-md-8 mb-3">
                            <select class="form-control form-select" name="event" id="event" onchange="form.submit()">
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
                            <div class="text-danger"><?= @$message['error_event'] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="event_date" class="form-label"><span class="text-danger">* </span>Event Date</label>
                        </div>
                        <div class="col-md-8 mb-3">
                            <?php
                            $today = date('Y-m-d');
                            $mindate = date('Y-m-d', strtotime('+14 days', strtotime($today)));
                            $maxdate = date('Y-m-d', strtotime('+1 year', strtotime($today)));
                            ?>
                            <input type="date" min="<?= $mindate ?>" max="<?= $maxdate ?>" class="form-control" placeholder="Pick a Date" id="event_date" name="event_date" value="<?= @$event_date ?>">
                            <div class="text-danger"><?= @$message['error_event_date'] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="guest_count" class="form-label"><span class="text-danger">* </span>Guest Count</label>
                        </div>
                        <div class="col-md-8 mb-3">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT MIN(min_capacity) AS min,MAX(max_capacity) AS max FROM hall";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $min = $row['min'];
                            $max = $row['max'];
                            ?>
                            <input type="number" min="<?= $min ?>" max="<?= $max ?>" class="form-control" name="guest_count" value="<?= @$guest_count ?>">
                            <div class="text-danger"><?= @$message['error_guest_count'] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="function_mode" class="form-label"><span class="text-danger">* </span>Function Mode</label>
                        </div>
                        <?php
                        //echo 'outside if';
                        if (!empty($event)) {
                            //echo 'inside if';
                            $db = dbConn();
                            $sql = "SELECT fm.function_mode,efm.function_mode_id FROM event_function_mode efm LEFT JOIN function_mode fm ON efm.function_mode_id=fm.function_mode_id WHERE event_id ='$event'";
                            $result = $db->query($sql);
                            ?>
                            <div class="col-md-8 mb-3">
                                <select class="form-control" name="function_mode">
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value=<?= $row['function_mode_id']; ?> <?php if ($row['function_mode_id'] == @$function_mode) { ?> selected <?php } ?>><?= $row['function_mode'] ?></option>
                                    <?php
                                }
                                ?>
                                    </select>
                            </div>
                            <?php
                        }else{
                            //echo 'elseif';
                        }
                        ?>

                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" style="text-align:right">
                            <button type="submit" class="btn btn-success" name="action" value="check_availability">Check Availability <i class="bi bi-arrow-right-circle-fill"></i></button>
                        </div>
                    </div>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'check_availability') {
                        $message = array();

                        if (empty($event)) {
                            $message['error_event'] = "Event Should be Selected";
                        }

                        if (empty($event_date)) {
                            $message['error_event_date'] = "Event Date Should be Selected";
                        }

                        if (empty($guest_count)) {
                            $message['error_guest_count'] = "Guest Count Should not be Empty";
                        }
                        //var_dump($message);

                        if (empty($message)) {
                            $db = dbConn();
                            $sql = "SELECT he.hall_id,h.hall_no,hall_name FROM hall_event he LEFT JOIN hall h on he.hall_id=h.hall_id "
                                    . "WHERE he.event_id = $event AND h.min_capacity <= $guest_count AND h.max_capacity >= $guest_count";
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $hall_id = $row['hall_id'];
                                    $sql_time = "SELECT function_mode_id,duration,time_gap FROM event_function_mode WHERE event_id = $event AND function_mode_id = $function_mode";
                                    $result_time = $db->query($sql_time);
                                    if ($result_time->num_rows > 0) {
                                        while ($row_time = $result_time->fetch_assoc()) {
                                            //var_dump($row_time);
                                            $duration = $row_time['duration'];
                                            $duration_string = '+' . $duration;

                                            $time_gap = $row_time['time_gap'];
                                            $time_gap_string = '+' . $time_gap;

                                            $sql1 = "SELECT open_time,close_time FROM hotel_details";
                                            $result1 = $db->query($sql1);
                                            $row1 = $result1->fetch_assoc();
                                            //$open_time = date('H:i',strtotime($row1['open_time']));
                                            //$close_time = date('H:i',strtotime($row1['close_time']));
                                            if($function_mode == 1){
                                                
                                            }
                                            $open_time = strtotime($row1['open_time']);
                                            $close_time = strtotime($row1['close_time']);
                                            //var_dump($close_time);
                                            //var_dump($open_time);

                                            $duration_insec = intval($duration) * 60;
                                            //$time = $open_time+$duration_insec;
                                            //var_dump($time);
                                            //var_dump($duration_insec);
                                            $time_slots = array();
                                            //var_dump($time_slots);
                                            for ($time = $open_time; $time <= $close_time; $time += $duration_insec) {
                                                //var_dump($time);
                                                $time_slots[] = date('H:i', $time);
                                            }
                                            var_dump($time_slots);
                                            $t = 0;
                                            //echo "outside";
                                            echo $row['hall_name'];
                                            foreach ($time_slots as $slot) {
                                                //echo "inside";
                                                //echo $t;
                                                if ($t == 0) {
                                                    $start_time = date('H:i', strtotime($slot));
                                                    $end_time = date('H:i', strtotime($duration_string, strtotime($start_time)));
                                                } else {
                                                    $start_time = date('H:i', strtotime($time_gap_string, strtotime($end_time)));
                                                    $end_time = date('H:i', strtotime($duration_string, strtotime($start_time)));
                                                }

                                                if (strtotime($end_time) <= $close_time) {
                                                    $sql_slot = "SELECT COUNT(*) as tslotcount FROM reservation WHERE "
                                                            . "date='$event_date' AND hall_id ='$hall_id' AND status_id ='2' AND "
                                                            . "((start_time BETWEEN '$start_time' AND '$end_time') OR "
                                                            . "(end_time BETWEEN '$start_time' AND '$end_time') OR "
                                                            . "(start_time<='$start_time' AND end_time>='$end_time') "
                                                            . "OR start_time='$end_time' OR end_time='$start_time')";
                                                    $result_slot = $db->query($sql_slot);
                                                    $row_slot = $result_slot->fetch_assoc();
                                                    if ($row_slot['tslotcount'] == 0) {
                                                        //$t_s = $start_time . " - " . $end_time;
                                                        ?>
                                                        <input class="form-check-input" type="radio" name="time_slot" id="time_slot" value="<?= $start_time . " - " . $end_time ?>">
                                                        <label class="form-check-label"><?= $start_time . " - " . $end_time ?></label>
                                                        <?php
                                                    }else{
                                                        echo 'Unavailable';
                                                    }
                                                }
                                            }
                                            echo "<br>";
                                        }
                                    }
                                }
                                
                            }



                            //echo $sql = "SELECT he.hall_id,h.hall_no FROM hall_event he LEFT JOIN hall h on he.hall_id=h.hall_id "
                            //          ."WHERE he.event_id = $event AND h.min_capacity <= $guest_count AND h.max_capacity >= $guest_count";
//                            $result = $db->query($sql);
//                            if ($result->num_rows > 0) {
//                                while ($row = $result->fetch_assoc()) {
//                                    
//                                }
//                            }
                        }
                    }
                    ?>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>