<?php
ob_start();
session_start();
include '../header.php';
?>

<main id="main">
    <section>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!empty($_SESSION['event_details'])) {
                $event = $_SESSION['event_details']['event'];
                $function_mode = $_SESSION['event_details']['function_mode'];
                $event_date = $_SESSION['event_details']['event_date'];
                $guest_count = $_SESSION['event_details']['guest_count'];
            }
        }
        extract($_POST);
        var_dump($_POST);
        $action_array = explode('.',@$action);
        $action = @$action_array[0];
        $selected_hall = @$action_array[1];
        
        if($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'book_now'){
            
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'check_availability') {
            //var_dump($_POST);
            $message = array();
            //var_dump($message);

            if (empty($event)) {
                $message['error_event'] = "Event Should be Selected";
            }

            if (empty($function_mode)) {
                $message['error_function_mode'] = "Function Mode Should be Selected";
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
                $sql = "SELECT start_time,end_time FROM event_function_mode WHERE event_function_mode_id = $function_mode";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                $start_time = $row['start_time'];
                $start_time = date('H:i', strtotime($start_time));
                $end_time = $row['end_time'];
                $end_time = date('H:i', strtotime($end_time));

                $sql_hall = "SELECT h.hall_id,h.hall_no,h.hall_name FROM hall h "
                        . "LEFT JOIN hall_event he ON h.hall_id=he.hall_id "
                        . "WHERE availability = 'Available' "
                        . "AND he.event_id='$event' "
                        . "AND '$guest_count' BETWEEN h.min_capacity AND h.max_capacity "
                        . "AND h.hall_id NOT IN "
                        . "(SELECT hall_id FROM reservation WHERE event_date='$event_date' AND reservation_status_id != '2' "
                        . "AND ((start_time BETWEEN '$start_time' AND '$end_time') "
                        . "OR (end_time BETWEEN '$start_time' AND '$end_time') "
                        . "OR (start_time <= '$start_time' AND end_time >= '$end_time') "
                        . "OR (start_time = '$end_time') "
                        . "OR (end_time = '$start_time'))) ORDER BY h.hall_id ASC";
                $result_hall = $db->query($sql_hall);
                if ($result_hall->num_rows > 0) {
                    while ($row_hall = $result_hall->fetch_assoc()) {
                        $available_halls[$row_hall['hall_id']] = array('hall_id' => $row_hall['hall_id']);
                    }
                }
                $db = dbConn();
                $sql = "SELECT function_mode_id,start_time,end_time FROM event_function_mode WHERE event_function_mode_id = '$function_mode'";
                $result = $db->query($sql);
                $row = $result->fetch_assoc();
                $_SESSION['event_details'] = array('event' => $event, 'function_mode' => $row['function_mode_id'], 'start_time' => $row['start_time'], 'end_time' => $row['end_time'], 'event_date' => $event_date, 'guest_count' => $guest_count);
            }
        }
        ?>
        <div class="row mt-3">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h3>Check Availability</h3>
                </div>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="font-size:13px;">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="event" class="form-label"><span class="text-danger">* </span>Event</label>
                        </div>
                        <div class="col-md-8 mb-3">
                            <select class="form-control form-select" name="event" id="event" onchange="form.submit()" style="font-size:13px;">
                                <option value="" style="text-align:center">Select an Event</option>
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
                            <label for="function_mode" class="form-label"><span class="text-danger">* </span>Function Mode</label>
                        </div>
                        <div class="col-md-8 mb-3">
                            <select class="form-control form-select" id="function_mode" name="function_mode" style="font-size:13px;">
                                <option value="" disabled selected >-Select a Function Mode-</option>
                                <?php
                                $db = dbConn();
                                if (!empty($event)) {
                                    echo $sql = "SELECT efm.event_function_mode_id,fm.function_mode_id,fm.function_mode,start_time,end_time from function_mode fm LEFT JOIN event_function_mode efm ON fm.function_mode_id=efm.function_mode_id WHERE event_id='$event'";
                                } else {
                                    echo $sql = "SELECT * from function_mode";
                                }

                                $result = $db->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    $event_start_time = $row['start_time'];
                                    $event_end_time = $row['end_time'];
                                    if (!empty($event)) {
                                        $function_mode = $row['event_function_mode_id'];
                                    } else {
                                        $function_mode = $row['function_mode_id'];
                                    }
                                    ?>
                                    <option value=<?= $function_mode ?> <?php if ($row['event_function_mode_id'] == @$function_mode || $row['function_mode_id'] == @$function_mode) { ?> selected <?php } ?>><?= (!empty($event)) ? $row['function_mode'] . " - ( " . $event_start_time . " - " . $event_end_time . " )" : $row['function_mode'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <div class="text-danger"><?= @$message['error_function_mode'] ?></div>
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
                            <input type="date" min="<?= $mindate ?>" max="<?= $maxdate ?>" class="form-control" placeholder="Pick a Date" id="event_date" name="event_date" value="<?= @$event_date ?>" style="font-size:13px;">
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
                            <input type="number" min="<?= $min ?>" max="<?= $max ?>" class="form-control" name="guest_count" value="<?= @$guest_count ?>" style="font-size:13px;">
                            <div class="text-danger"><?= @$message['error_guest_count'] ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" style="text-align:right">
                            <button type="submit" class="btn btn-success btn-sm" name="action" value="check_availability">Check Availability <i class="bi bi-clock-fill"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <?php
                if (!empty($available_halls)) {
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <p style='text-align:center'><strong><i>Following halls are available for your reservation select a hall to make the reservation</i></strong><br><br><p>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($available_halls as $hall) {
                            $sql = "SELECT * FROM hall WHERE hall_id =" . $hall['hall_id'];
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            ?>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <strong><?= $row['hall_no'] . ' - ' . $row['hall_name'] ?></strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <?php
                                            if (!empty($row['hall_image'])) {
                                                $image = $row['hall_image'];
                                            } else {
                                                $image = 'noImage.png';
                                            }
                                            ?>
                                            <div class="col-md-12 text-center" style="background-image:url('../../system/assets/images/hall/<?=$image?>');background-size:cover;width:350px;height:270px;"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="text-align:left">
                                                <p style="margin:5px;">Minimum Capacity: <?= $row['min_capacity'] ?></p>
                                                <p style="margin:5px;">Maximum Capacity: <?= $row['max_capacity'] ?></p>
                                                <p style="margin:5px;">Facilities:</p>
                                                <?php
                                                if ($row['facilities']) {
                                                    $facilities_list = explode(",", $row['facilities']);
                                                    echo "<ul style='list-style-type:none'>";
                                                    foreach ($facilities_list as $value) {
                                                        echo "<li><i class='bi bi-check-lg'></i>" . $value . "</li>";
                                                    }
                                                    echo "</ul>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="text-align: right">
                                                <button type="submit" name="action" value="book_now.<?= $hall['hall_id'] ?>" class="btn btn-warning btn-sm" onclick="form.submit()">Book Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'check_availability')
                            echo "<p style='text-align:center'><strong><i>Sorry... Our halls are not available for the day of your reservation. You can select another date for your event a hall to make the reservation</i></strong><br><br><p>";
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php
include '../footer.php';
ob_end_flush();
?>