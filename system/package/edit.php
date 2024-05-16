<?php
ob_start();
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>package/package.php">Package</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>package/package.php"><i class="bi bi-calendar"></i> Search Package</a>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
        
        $package_id = $_GET['package_id'];

        $db = dbConn();
        $sql = "SELECT * FROM package WHERE package_id='$package_id'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $package_name = $row['package_name'];
                $event_type = $row['event_id'];
                $menu_package = $row['menu_package_id'];
                $pax_count = $row['pax_count'];
                $total_price = $row['total_price'];
                $service_charge = $row['service_charge'];
                $final_price = $row['final_price'];
                $display_price = $row['display_price'];
                $per_person_price = $row['per_person_price'];
                $availability = $row['availability'];
            }
        }

        $sql = "SELECT s.service_id,s.service_name,ps.service_price,sc.category_name,sc.category_id FROM package_services ps"
                . " INNER JOIN service s ON ps.service_id=s.service_id"
                . " INNER JOIN service_category sc ON ps.category_id=sc.category_id"
                . " WHERE package_id=$package_id";
        //print_r($sql);
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) {
            $_SESSION['selected_services'][$row['service_id']] = array('service_id' => $row['service_id'], 'service_name' => $row['service_name'], 'service_price' => $row['service_price'], 'category_id' => $row['category_id'], 'category_name' => $row['category_name']);
        }
    }


    extract($_POST);
    @$action_array = explode('.', @$action);
    $action = $action_array[0];
    //var_dump($_POST);
    if (!empty($services)) {
        foreach ($services as $value) {
            $db = dbConn();
            $sql = "SELECT s.service_id,s.service_name,s.final_price,sc.category_name,sc.category_id FROM service s INNER JOIN service_category sc ON sc.category_id=s.category_id WHERE s.service_id='$value'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $_SESSION['selected_services'][$row['service_id']] = array('service_id' => $row['service_id'], 'service_name' => $row['service_name'], 'service_price' => $row['final_price'], 'category_id' => $row['category_id'], 'category_name' => $row['category_name']);
        }
        //print_r($_SESSION['selected_services']);
    }

    if (!empty($_SESSION['selected_services'])) {
        $selected_service_price = 0;
        foreach ($_SESSION['selected_services'] as $unit) {
            $selected_service_price += $unit['service_price'];
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'remove_service' && !empty(@$service_id)) {
        echo $service_id = $action_array[1];
        $selected_service_price -= $_SESSION['selected_services'][@$service_id]['service_price'];
        unset($_SESSION['selected_services'][$service_id]);
    }

    if (!empty($menu_package)) {
        $db = dbConn();
        $sql = "SELECT final_price FROM menu_package WHERE menu_package_id=$menu_package";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $menu_package_price = $row['final_price'];
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == 'save_changes') {
        $package_name = cleanInput($package_name);
        $service_charge = cleanInput($service_charge);

        $message = array();
        if (empty($package_name)) {
            $message['error_package_name'] = "The Package Name Should Not Be Blank...";
        }
        if (empty($event_type)) {
            $message['error_event_type'] = "An Event Type Should Be Selected...";
        }
        if (empty($menu_package)) {
            $message['error_menu_package'] = "A Menu Package Should Be Selected...";
        }
        if (empty($service_charge)) {
            $message['error_service_charge'] = "The Service Charge Should Not Be Blank...";
        }
        if (!isset($availability)) {
            $message['error_availability'] = "The Package Status Should Be Selected...";
        }
        if (!empty($service_charge)) {
            if (!is_numeric($service_charge)) {
                $message['error_service_charge'] = "The Service Charge Invalid...";
            } elseif ($service_charge < 0) {
                $message['error_service_charge'] = "The Service Charge Cannot Be Negative...";
            }
        }

        $total_price = str_replace(',', '', $total_price);
        $final_price = str_replace(',', '', $final_price);
        $display_price = str_replace(',', '', $display_price);
        $per_person_price = str_replace(',', '', $per_person_price);
        if (empty($message)) {
            $db = dbConn();
            //echo 'Connected..!';
            $sql = "SELECT * FROM package WHERE package_id='$package_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();

            $updated_fields = getUpdatedFields($row, $_POST);
            //var_dump($updated_fields);
            $updated_fields_string = implode(',', $updated_fields);

            $userid = $_SESSION['userid'];
            $cDate = date('Y-m-d');
            $sql = "UPDATE package SET package_name = '$package_name',event_id = '$event_type',menu_package_id = '$menu_package',total_price = '$total_price',service_charge = '$service_charge',final_price = '$final_price',display_price = '$display_price',per_person_price = '$per_person_price',availability = '$availability',update_user = '$userid',update_date = '$cDate' WHERE package_id = '$package_id'";
            $db->query($sql);

            $sql = "DELETE FROM package_services WHERE package_id = '$package_id'";
            $db->query($sql);

            foreach ($_SESSION['selected_services'] as $units) {
                $service_category_id = $units['category_id'];
                $selected_service_id = $units['service_id'];
                $service_price = $units['service_price'];
                $sql = "INSERT INTO package_services(package_id,category_id,service_id,service_price)VALUES('$package_id','$service_category_id','$selected_service_id','$service_price')";
                //print_r($sql);
                $db->query($sql);
            }

            header('Location:edit_success.php?package_id=' . $package_id . '&values=' . urlencode($updated_fields_string));
            unset($_SESSION['selected_services']);
        }
    }
    ?>
    <div class="row">
        <div class="mb-3 col-md-12">
            <div class="card bg-light">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Create a Package</h4>
                        </div>
                        <div class="col-md-6" style="text-align:right">
                            <p class="text-danger text-right">* Required</p>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="font-size:13px;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="package_name" class="form-label"><span class="text-danger">*</span> Name</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <input type="text" class="form-control" id="package_name" name="package_name" value="<?= @$package_name ?>" style="font-size:13px;">
                                        <div class="text-danger"><?= @$message["error_package_name"] ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="event_type" class="form-label"><span class="text-danger">*</span> Event Type</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <select class="form-control form-select" id="event_type" name="event_type" style="font-size:13px;" onchange="form.submit()">
                                            <option value="" selected >-Select an Event Type-</option>
                                            <?php
                                            $db = dbConn();
                                            $sql = "SELECT * from event";
                                            $result = $db->query($sql);
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value=<?= $row['event_id']; ?> <?php if ($row['event_id'] == @$event_type) { ?> selected <?php } ?>><?= $row['event_name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="text-danger"><?= @$message["error_event_type"] ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="menu_package" class="form-label"><span class="text-danger">*</span>Menu</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <select class="form-control form-select" id="menu_package" name="menu_package" style="font-size:13px;" onchange="form.submit()">
                                            <option value="" selected >-Select a Menu-</option>
                                            <?php
                                            $db = dbConn();
                                            $sql = "SELECT * from menu_package";
                                            $result = $db->query($sql);
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <option value=<?= $row['menu_package_id']; ?> <?php if ($row['menu_package_id'] == @$menu_package) { ?> selected <?php } ?>><?= $row['menu_package_name'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <div class="text-danger"><?= @$message["error_food_menu"] ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="pax_count" class="form-label"><span class="text-danger">*</span> Pax Count</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <input type="number" min="1" class="form-control" id="pax_count" name="pax_count" value="<?= @$pax_count ?>" onchange="form.submit()" style="font-size:13px;">
                                        <div class="text-danger"><?= @$message["error_pax_count"] ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="total_price" class="form-label">Total Price (Rs.)</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <?php
                                        if (!empty($menu_package) && !empty($pax_count)) {
                                            $db = dbConn();
                                            $sql = "SELECT final_price FROM menu_package WHERE menu_package_id=$menu_package";
                                            $result = $db->query($sql);
                                            $row = $result->fetch_assoc();
                                            $menu_package_price = $row['final_price'];
                                            if (!empty($selected_service_price)) {
                                                $total_price = ($menu_package_price * $pax_count) + $selected_service_price;
                                            } elseif (empty($selected_service_price)) {
                                                $total_price = ($menu_package_price * $pax_count);
                                            }
                                        }

                                        if (!empty($total_price)) {
//                                            var_dump($total_price);
//                                            var_dump($menu_package_price);
//                                            var_dump(@$selected_service_price);
                                            $total_price = floatval($total_price);
                                            $total_price = number_format($total_price, '2', '.', ',');
                                        }
                                        ?>
                                        <input type="text" readonly class="form-control" id="total_price" name="total_price" value="<?= @$total_price ?>" style="font-size:13px;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="service_charge" class="form-label"><span class="text-danger">*</span> Service Charge (%)</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <?php
                                        if (!empty($service_charge)) {
                                            $service_charge = number_format($service_charge, '2');
                                        }
                                        ?>
                                        <input type="number" min="0" max="100" class="form-control" id="service_charge" name="service_charge" onchange="form.submit()" value="<?= @$service_charge ?>" style="font-size:13px;">
                                        <div class="text-danger"><?= @$message["error_service_charge"] ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="final_price" class="form-label">Final Price (Rs.)</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <?php
                                        if (!empty($total_price) && !empty($service_charge)) {
                                            $final_price = str_replace(',', '', $total_price) + floatval(str_replace(',', '', $total_price) * floatval($service_charge)) / 100;
                                            @$final_price = floatval($final_price);
                                            @$final_price = number_format($final_price, '2', '.', ',');
                                        }
                                        ?>
                                        <input type="text" class="form-control" id="final_price" name="final_price" value="<?= @$final_price ?>" readonly style="font-size:13px;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="display_price" class="form-label">Display Price (Rs.)</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <?php
                                        if (!empty($final_price)) {
                                            $display_price = ceil(str_replace(',', '', $final_price) / 100) * 100;
                                            $display_price = floatval($display_price);
                                            $display_price = number_format($display_price, '2', '.', ',');
                                        }
                                        ?>
                                        <input type="text" class="form-control" id="display_price" name="display_price" value="<?= @$display_price ?>" readonly style="font-size:13px;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="per_person_price" class="form-label">Per Person Price (Rs.)</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <?php
                                        if (!empty($display_price)) {
                                            $per_person_price = str_replace(',', '', $display_price) / $pax_count;
                                            $per_person_price = floatval($per_person_price);
                                            $per_person_price = number_format($per_person_price, '2', '.', ',');
                                        }
                                        ?>
                                        <input type="text" class="form-control" id="per_person_price" name="per_person_price" value="<?= @$per_person_price ?>" readonly style="font-size:13px;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label"><span class="text-danger">*</span> Availability</label>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="availability" id="available" value="Available" <?php if (isset($availability) && $availability == 'Available') { ?> checked <?php } ?>>
                                                    <label class="form-check-label" for="available">Available</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="availability" id="unavailable" value="Unavailable" <?php if (isset($availability) && $availability == 'Unavailable') { ?> checked <?php } ?>>
                                                    <label class="form-check-label" for="unavailable">Unavailable</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-danger"><?= @$message["error_availability"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="service_category" class="form-label"><span class="text-danger">*</span>Category</label>
                                                <select class="form-control form-select" id="service_category" name="service_category" onchange="form.submit()" style="font-size:13px;">
                                                    <option value="" disabled selected >-Select a Category-</option>
                                                    <?php
                                                    $db = dbConn();
                                                    //$sql = "SELECT category_id,category_name from service_category WHERE availability='Available' AND category_id IN (SELECT category_id FROM service WHERE service_id IN (SELECT service_id FROM event_service WHERE event_id='$event_type'))";
                                                    if(!empty($event_type)){
                                                        $sql = "SELECT DISTINCT sc.category_id,sc.category_name FRom service_category sc LEFT JOIN service s ON s.category_id=sc.category_id "
                                                                . "WHERE s.service_id IN (SELECT service_id FROM event_service WHERE event_id = '$event_type')";
                                                    }else{
                                                        $sql = "SELECT * FROM service_category";
                                                    }
                                                    //print_r($sql);
                                                    $result = $db->query($sql);
                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                        <option value=<?= $row['category_id']; ?> <?php if ($row['category_id'] == @$service_category) { ?> selected <?php } ?>><?= $row['category_name'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_service_category"] ?></div>
                                            </div>
                                            <div class="col-md-6">
                                                <?php
                                                $item = array();
                                                if (!empty(@$service_category)) {
                                                    $db = dbConn();
                                                    $sql = "SELECT service_id,service_name,final_price FROM service WHERE category_id=$service_category";
                                                    $result = $db->query($sql);

                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>
                                                        <div class="form-check form-check">
                                                            <input class="form-check-input" type="checkbox" id="<?= $row['service_id'] ?>" name="services[]" value="<?= $row['service_id'] ?>" <?php if (isset($services) && in_array($row['service_id'], $services)) { ?>checked <?php } ?>>
                                                            <label class="form-check-label" for="<?= $row['service_id'] ?>"><?= $row['service_name'] . " - Rs." . number_format($row['final_price'], '2', '.', ',') ?></label>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3" style="text-align:right">
                                                <button type="submit" name="action" value="add_service" class="btn btn-sm btn-success" style="width:100px;font-size:13px;" onclick="form.submit()">Add</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10 table-responsive">
                                                <table class="table table-striped table-secondary">
                                                    <thead class="bg-secondary">
                                                        <tr>
                                                            <th>Category</th>
                                                            <th>Service</th>
                                                            <th>Price</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'add_service') {
                                                            if (!empty($_SESSION['selected_services'])) {
                                                                foreach ($_SESSION['selected_services'] as $unit) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $unit['category_name'] ?></td>
                                                                        <td><?= $unit['service_name'] ?></td>
                                                                        <td><?= number_format($unit['service_price'], '2', '.', ',') ?></td>
                                                                        <td>
                                                                            <button type="submit" class="btn btn-sm" onclick="form.submit()" name="action" value="remove_service.<?= $unit['service_id'] ?>"><span data-feather="trash-2"></span></button>
                                                                        </td>
                                                                    </tr>

                                                                    <?php
                                                                }
                                                            }
                                                        } elseif($_SERVER['REQUEST_METHOD'] =='GET' || $_SERVER['REQUEST_METHOD'] == 'POST') {
                                                            if (!empty($_SESSION['selected_services'])) {
                                                                //var_dump($_SESSION['selected_services']);
                                                                foreach ($_SESSION['selected_services'] as $unit) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $unit['category_name'] ?></td>
                                                                        <td><?= $unit['service_name'] ?></td>
                                                                        <td><?= number_format($unit['service_price'], '2', '.', ',') ?></td>
                                                                        <td>
                                                                            <button type="submit" class="btn btn-sm" onclick="form.submit()" name="action" value="remove_service.<?= $unit['service_id'] ?>"><span data-feather="trash-2"></span></button>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align:right">
                                <input type="hidden" name="package_id" value="<?= @$package_id ?>">
                                <button type="submit" class="btn btn-success btn-sm" style="width:150px;font-size:13px;" name="action" value="save_changes">Save Changes</button>
                                <a href="<?= SYSTEM_PATH ?>package/edit.php?package_id=<?= $package_id ?>" class="btn btn-warning btn-sm" style="width:100px;;font-size:13px;">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include '../footer.php';
ob_end_flush();
?>