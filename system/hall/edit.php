<?php
ob_start();
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>hall/hall.php">Halls</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>hall/hall.php"><i class="bi bi-calendar"></i> Search Hall</a>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
        //echo 'GET';
        //var_dump($_GET);
        $db = dbConn();
        $sql = "SELECT * FROM hall WHERE hall_id = '$hall_id'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //var_dump($row);
                $hall_name = $row['hall_name'];
                $min_cap = $row['min_capacity'];
                $max_cap = $row['max_capacity'];
                $facilities = $row['facilities'];
                $hall_image = $row['hall_image'];
                $availability = $row['availability'];
            }
        }
        $sql = "SELECT * FROM hall_event WHERE hall_id='$hall_id'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $events = array();
            while ($row = $result->fetch_assoc()) {
                $events[] = $row['event_id'];
            }
        }
    }

    //extract the array
    extract($_POST);
    //echo 'POST';
    //var_dump($_POST);
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'save_changes') {

        // Assign cleaned values to the variables
        $hall_name = cleanInput($hall_name);
        $min_cap = cleanInput($min_cap);
        $max_cap = cleanInput($max_cap);
        $facilities = cleanInput($facilities);

        //Required Validation
        $message = array();
        if (empty($hall_name)) {
            $message['error_hall_name'] = "The Hall Name Should Not Be Blank...";
        }
        if (empty($min_cap)) {
            $message['error_min_cap'] = "The Minimum Capacity Should Not Be Blank...";
        }
        if (empty($max_cap)) {
            $message['error_max_cap'] = "The Maximum Capacity Should Not Be Blank...";
        }
        if (!isset($availability)) {
            $message['error_availability'] = "The Availability Should Be Selected...";
        }

        if (empty($message)) {
            if (!empty($_FILES['hall_image']['name'])) {
                $hall_image = uploadFiles("hall_image", $hall_name, "../assets/images/hall/");
                //print_r($item_image);
                $hall_image_name = $hall_image['file_name'];
                if (!empty($hall_image['error_message'])) {
                    $message['error_hall_image'] = $hall_image['error_message'];
                }
            } else {
                $hall_image_name = $prev_image;
            }
        }
        //var_dump($message);
        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';

            $sql = "SELECT * FROM hall WHERE hall_id = '$hall_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();

            $updated_fields = getUpdatedFields($row, $_POST);
            //var_dump($updated_fields);
            $updated_fields_string = implode(',', $updated_fields);

            $sql = "SELECT * FROM hall_event WHERE hall_id='$hall_id'";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $old_events = array();
                while ($row = $result->fetch_assoc()) {
                    $old_events[] = $row['event_id'];
                }
            }
            $updated_hall_events = getUpdatedFields($old_events, $events);
            $updated_hall_events_string = implode(',', $updated_hall_events);

            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "UPDATE hall SET hall_name = '$hall_name',min_capacity = '$min_cap',max_capacity = '$max_cap',facilities = '$facilities',hall_image = '$hall_image_name',availability = '$availability',update_user = '$userid',update_date = '$cDate' WHERE hall_id = '$hall_id'";
            $db->query($sql);
            //print_r($sql);
            $sql = "DELETE FROM hall_event WHERE hall_id='$hall_id'";
            $db->query($sql);

            foreach ($events as $value) {
                $sql = "INSERT INTO hall_event(hall_id,event_id) VALUES('$hall_id','$value')";
                $db->query($sql);
            }

            header('Location:edit_success.php?hall_id=' . $hall_id . '&updated_hall_values=' . urlencode($updated_fields_string) . '&updated_hall_events=' . urlencode($updated_hall_events_string));
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-1"></div>
        <div class="mb-3 col-md-10">
            <div class="card bg-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Add a New Item</h4>
                        </div>
                        <div class="col-md-6" style="text-align:right">
                            <p class="text-danger text-right">* Required</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="hall_name" class="form-label"><span class="text-danger">*</span> Hall Name</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <input type="text" class="form-control" id="hall_name" name="hall_name" value="<?= @$hall_name ?>">
                                        <div class="text-danger"><?= @$message["error_hall_name"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label"><span class="text-danger">*</span> Availability</label><br>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="availability" id="hall_available" value="Available" <?php if (isset($availability) && $availability == 'Available') { ?> checked <?php } ?>>
                                            <label class="form-check-label" for="hall_available">Available</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="availability" id="hall_unavailable" value="Unavailable" <?php if (isset($availability) && $availability == 'Unavailable') { ?> checked <?php } ?>>
                                            <label class="form-check-label" for="hall_unavailable">Unavailable</label>
                                        </div>
                                        <div class="text-danger"><?= @$message["error_availability"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="min_cap" class="form-label"><span class="text-danger">*</span> Min Capacity</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <input type="number" min="1" class="form-control" id="min_cap" name="min_cap" onchange="form.submit()" value="<?= @$min_cap ?>">
                                        <div class="text-danger"><?= @$message["error_min_cap"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="max_cap" class="form-label"><span class="text-danger">*</span> Max Capacity</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <input type="number" min="<?= @$min_cap ?>" class="form-control" id="max_cap" name="max_cap" value="<?= @$max_cap ?>">
                                        <div class="text-danger"><?= @$message["error_max_cap"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="facilities" class="form-label"><span class="text-danger">*</span> Facilities</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <textarea class="form-control" id="facilities" name="facilities"><?= @$facilities ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="hall_image" class="form-label">Image</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <?php
                                        if (!empty($hall_image)) {
                                            $prev_image = $hall_image;
                                        } elseif (!empty($prev_image)) {
                                            $prev_image = $prev_image;
                                        } else {
                                            $prev_image = 'noImage.png';
                                        }
                                        ?>
                                        <input type="hidden" name="prev_image" value="<?= @$prev_image ?>">
                                        <input type="file" name="hall_image" id="hall_image" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="events" class="form-label"><span class="text-danger">*</span> Allowed Events</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM event";
                                        $result = $db->query($sql);
//                                        $count_sql = "SELECT count(*) as count FROM event";
//                                        $result_count = $db->query($count_sql);
//                                        $count_row = $result_count->fetch_assoc();
//                                        $count = $count_row['count'];
//                                        $items_per_col = $count/2;
//                                        for($i=0;$i<=$items_per_col;$i++){
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <input class="form-check-input" type="checkbox" id="<?= $row['event_id'] ?>" name="events[]" value="<?= $row['event_id'] ?>" <?php if (isset($events) && in_array($row['event_id'], $events)) { ?>checked <?php } ?>>
                                            <label class="form-check-label" for="<?= $row['event_id'] ?>"><?= $row['event_name'] ?></label><br>
                                            <?php
                                        }
                                        //}
                                        ?>
                                        <div class="text-danger"><?= @$message["error_events"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align:right">
                                <input type="hidden" name="hall_id" value="<?=@$hall_id?>">
                                <button type="submit" class="btn btn-success btn-sm" style="width:150px;" name="action" value="save_changes">Save Changes</button>
                                <a href="<?= SYSTEM_PATH ?>hall/add.php" class="btn btn-warning btn-sm" style="width:150px;">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-3 col-md-1"></div>
    </div>
</main>
<?php
include '../footer.php';
ob_end_flush()
?>