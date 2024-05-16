<?php ob_start() ?>
<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/service.php">Service</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/services.php">Services</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/services.php"><i class="bi bi-calendar"></i> Search Service</a>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
        //var_dump($_GET);
        $db = dbConn();
        $sql = "SELECT * FROM service WHERE service_id = '$service_id'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //var_dump($row);
                $service_category = $row['category_id'];
                $service_name = $row['service_name'];
                $service_price = $row['service_price'];
                $profit_ratio = $row['profit_ratio'];
                $final_price = $row['final_price'];
                $availability = $row['availability'];
                $service_type = $row['service_type'];
                $addon_status = $row['addon_status'];
            }
        }

        $sql = "SELECT event_id FROM event_service WHERE service_id = '$service_id'";
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $event) {
                $events[] = $event;
            }
        }
    }

    //extract the array
    extract($_POST);
    //var_dump($_POST);
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'save_changes') {

        // Assign cleaned values to the variables
        $service_name = cleanInput($service_name);
        $service_price = cleanInput($service_price);
        $profit_ratio = cleanInput($profit_ratio);

        //Required Validation
        $message = array();
        if (empty($service_category)) {
            $message['error_service_category'] = "The Service Category Should be Selected...";
        }
        if (empty($service_name)) {
            $message['error_service_name'] = "The Service Name Should Not Be Blank...";
        }
        if (empty($addon_status)) {
            $message['error_addon_status'] = "The Addon Status Should Be Selected...";
        }
        if (empty($service_price)) {
            $message['error_service_price'] = "The Service Price Should Not Be Blank...";
        }
        if (empty($profit_ratio)) {
            $message['error_profit_ratio'] = "The Profit Ratio Should Not Be Blank...";
        }
        if (!isset($availability)) {
            $message['error_availability'] = "The Service Status Should Be Select...";
        }
        if (empty($service_type)) {
            $message['error_service_type'] = "The Service Type Should be Selected...";
        }
        if (empty($events)) {
            $message['error_events'] = "The Allowed Events Should Be Selected...";
        }

        //Advance Validation
        $service_price = str_replace(',', '', $service_price);
        if (!empty($service_price)) {
            if (!is_numeric($service_price)) {
                $message['error_service_price'] = "The Service Price Invalid...";
            } elseif ($service_price < 0) {
                $message['error_service_price'] = "The Service Price Cannot Be Negative...";
            }
        }

        if (!empty($profit_ratio)) {
            if (!is_numeric($profit_ratio)) {
                $message['error_profit_ratio'] = "The Profit Ratio Invalid...";
            } elseif ($profit_ratio < 0) {
                $message['error_profit_ratio'] = "The Profit Ratio Cannot Be Negative...";
            }
        }

        $final_price = str_replace(',', '', $final_price);

        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $sql = "SELECT * FROM service WHERE service_id = '$service_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();

            $updated_fields = getUpdatedFields($row, $_POST);
            //var_dump($updated_fields);
            $updated_fields_string = implode(',', $updated_fields);
            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "UPDATE service SET category_id = '$service_category',service_name = '$service_name',service_type='$service_type',"
                    . "addon_status = '$addon_status',service_price = '$service_price',profit_ratio = '$profit_ratio',final_price = '$final_price',availability = '$availability',update_user = '$userid',update_date='$cDate' WHERE service_id='$service_id'";
            $db->query($sql);

            $sql = "DELETE FROM event_service WHERE service_id='$service_id'";
            $db->query($sql);

            foreach ($events as $event) {
                $sql = "INSERT INTO event_service(service_id,event_id) VALUES('$service_id','$event')";
                $db->query($sql);
            }

            header('Location:edit_success.php?service_id=' . $service_id . '&values=' . urlencode($updated_fields_string));
        }
    }
    ?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card bg-light">
                <div class="card-header">
                    <h4>Update Service</h4>
                </div>
                <div class="card-body" style="font-size:13px;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="service_category" class="form-label"><span class="text-danger">*</span> Category</label>
                                    </div>
                                    <div class="mb-3 col-md-8">                      
                                        <select class="form-control form-select" id="service_category" name="service_category" style="font-size:13px;">
                                            <option value="" disabled selected>-Select a Category-</option>
                                            <?php
                                            $db = dbConn();
                                            $sql1 = "SELECT * from service_category";
                                            $result1 = $db->query($sql1);
                                            while ($row1 = $result1->fetch_assoc()) {
                                                ?>
                                                <option value=<?= $row1['category_id'] ?> <?php if ($row1['category_id'] == @$service_category) { ?>selected <?php } ?>><?= $row1['category_name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="text-danger"><?= @$message["error_service_category"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="service_name" class="form-label"><span class="text-danger">*</span> Name</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <input type="text" class="form-control" id="service_name" name="service_name" value="<?= @$service_name ?>" style="font-size:13px;">
                                        <div class="text-danger"><?= @$message["error_service_name"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><span class="text-danger">*</span> Availability</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="availability" id="available" value="Available" <?php if (isset($availability) && $availability == 'Available') { ?> checked <?php } ?>>
                                            <label class="form-check-label" for="available">Available</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="availability" id="unavailable" value="Unavailable" <?php if (isset($availability) && $availability == 'Unavailable') { ?> checked <?php } ?>>
                                            <label class="form-check-label" for="unavailable">Unavailable</label>
                                        </div>
                                        <div class="text-danger"><?= @$message["error_availability"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label"><span class="text-danger">*</span> Approved as Additional</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" onchange="form.submit()" type="radio" name="addon_status" id="approved" value="Yes" <?php if (isset($addon_status) && $addon_status == 'Yes') { ?> checked <?php } ?>>
                                                    <label class="form-check-label" for="approved">Yes</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" onchange="form.submit()" type="radio" name="addon_status" id="unapproved" value="No" <?php if (isset($addon_status) && $addon_status == 'No') { ?> checked <?php } ?>>
                                                    <label class="form-check-label" for="unapproved">No</label>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-6"></div>
                                        </div>
                                        <div class="text-danger"><?= @$message["error_addon_status"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="service_price" class="form-label"><span class="text-danger">*</span> Service Price (Rs.)</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <?php
                                        if (!empty($service_price) && is_numeric($service_price)) {
                                            $service_price = number_format($service_price, '2', '.', ',');
                                        }
                                        ?>
                                        <input type="text" class="form-control" id="service_price" name="service_price" value="<?= @$service_price ?>" style="font-size:13px;">
                                        <div class="text-danger"><?= @$message["error_service_price"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="profit_ratio" class="form-label"><span class="text-danger">*</span> Profit Ratio (%)</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <?php
                                        if (!empty($profit_ratio)) {
                                            $profit_ratio = number_format($profit_ratio, '2');
                                        }
                                        ?>
                                        <input type="number" min="0" max="100" class="form-control" onchange="form.submit()" id="profit_ratio" name="profit_ratio" value="<?= @$profit_ratio ?>" style="font-size:13px;">
                                        <div class="text-danger"><?= @$message["error_profit_ratio"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="final_price" class="form-label">Final Price (Rs.)</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <?php
                                        if (!empty($service_price) && is_numeric($profit_ratio)) {
                                            $sprice = str_replace(',', '', $service_price);
                                            $final_price = $sprice + ($sprice * $profit_ratio) / 100;
                                            $final_price = number_format($final_price, '2', '.', ',');
                                        }
                                        ?>
                                        <input type="text" readonly class="form-control" id="final_price" name="final_price" value="<?= @$final_price ?>" style="font-size:13px;">
                                        <div class="text-danger"><?= @$message["error_final_price"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="service_type" class="form-label">Service Type</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <select class="form-control form-select" id="service_type" name="service_type" style="font-size:13px;">
                                            <option value="" disabled selected>-Select a Type-</option>
                                            <option value="inhouse" <?php if (@$service_type == 'inhouse') { ?>selected <?php } ?>>In House</option>
                                            <option value="outsource" <?php if (@$service_type == 'outsource') { ?>selected <?php } ?>>Out Source</option>
                                        </select>
                                        <div class="text-danger"><?= @$message["error_service_type"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Service Allowed Events</label>
                                    </div>
                                    <div class="col-md-9 mb-3">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM event";
                                        $result = $db->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="<?= $row['event_id'] ?>" name="events[]" value="<?= $row['event_id'] ?>" <?php if (isset($events) && in_array($row['event_id'], $events)) { ?>checked <?php } ?>>
                                                <label class="form-check-label" for="<?= $row['event_id'] ?>"><?= $row['event_name'] ?></label>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="text-danger"><?= @$message["error_events"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12" style="text-align:right">
                                <input type="hidden" name="service_id" value="<?= @$service_id ?>">
                                <button type="submit" name="action" value="save_changes" class="btn btn-success btn-sm" style="width:150px;">Save Changes</button>
                                <a href="<?= SYSTEM_PATH ?>service/edit.php?service_id=<?= $service_id ?>" class="btn btn-warning btn-sm" style="width:150px;">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</main>

<?php include '../footer.php'; ?>
<?php
ob_end_flush()?>