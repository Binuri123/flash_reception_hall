<?php
ob_start();
include '../header.php';
include '../menu.php';
?>`
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>hall/hall.php">Hall</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
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
    //extract the array
    extract($_POST);
    //var_dump($_POST);
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'add') {

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
        if (!isset($events)) {
            $message['error_events'] = "Allowed Events Should be Selected";
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

        if (empty($message)) {
            $db = dbConn();
            echo 'Connected..!';
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "INSERT INTO hall(hall_name,min_capacity,max_capacity,facilities,hall_image,availability,add_user,add_date)VALUES('$hall_name','$min_cap','$max_cap','$facilities','$hall_image_name','$availability','$userid','$cDate')";
            $db->query($sql);
            print_r($sql);
            $hall_id = $db->insert_id;
            print_r($hall_id);
            if (strlen($hall_id) == 1) {
                $hall_no = "H - 00" . $hall_id;
            } elseif (strlen($hall_id) == 2) {
                $hall_no = "H - 0" . $hall_id;
            } else {
                $hall_no = "H - " . $hall_id;
            }

            $sql = "UPDATE hall SET hall_no='$hall_no' WHERE hall_id='$hall_id'";
            $db->query($sql);

            foreach ($events as $value) {
                $sql = "INSERT INTO hall_event(hall_id,event_id) VALUES('$hall_id','$value')";
                $db->query($sql);
            }
            header('Location:add_success.php?hall_id=' . $hall_id);
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
                                            <input class="form-check-input" type="radio" name="availability" id="hall_unavailable" value="Unavaiable" <?php if (isset($availability) && $availability == 'Unavailable') { ?> checked <?php } ?>>
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
                                <button type="submit" class="btn btn-success btn-sm" style="width:100px;" name="action" value="add">Add</button>
                                <a href="<?=SYSTEM_PATH?>hall/add.php" class="btn btn-warning btn-sm" style="width:100px;">Cancel</a>
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
ob_end_flush();
?>