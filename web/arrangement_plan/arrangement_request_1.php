<?php
ob_start();
include '../customer/header.php';
include '../customer/sidebar.php';
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Arrangement</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>arrangement_plan/arrangement_plan.php">Arrangement</a></li>
                <li class="breadcrumb-item active">Arrangement Request</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
    }
    extract($_POST);
    //var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'request') {
        //Required Field Validation
        $message = array();

        var_dump($message);
        if (empty($message)) {
            $db = dbConn();
            $sql = "SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'];
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $customer_no = $row['customer_no'];

            $cDate = date('Y-m-d');
            $user_id = $_SESSION['userid'];
            $sql = "INSERT INTO refund_request(reservation_no,customer_no,paid_amount,refundable_amount,"
                    . "refund_method_id,refund_status_id,requested_date,requested_user) "
                    . "VALUES('$reservation_no','$customer_no','$paid_amount','$refundable_amount',"
                    . "'$refund_method','2','$cDate','$user_id')";
            $db->query($sql);

            $refund_request_id = $db->insert_id;

            if ($refund_method == '2') {
                $sql = "INSERT INTO bank_refund(refund_request_id,bank_id,branch_name,account_holder_name,account_number) "
                        . "VALUES('$refund_request_id','$bank_name','$bank_branch','$account_holder','$account_number')";
            }

            if ($refund_method == '1') {
                echo $sql = "INSERT INTO cash_refund(refund_request_id,cash_collector,cash_collector_name,cash_collector_nic) "
                . "VALUES('$refund_request_id','$cash_collector','$collector_name','$collector_nic')";
            }

            $db->query($sql);

            header('location:refund_request_success.php?request_id=' . $refund_request_id);
        }
    }
    ?>
    <section class="section dashboard">
        <?php
        $db = dbConn();
        $sql = "SELECT * FROM reservation WHERE reservation_no = '$reservation_no'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $reservation_price = $row['discounted_price'];
        ?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card bg-light" style="font-size:13px;">
                    <div class="card-header">
                        <h3>Request an Arrangement</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5 mb-3 mt-3">
                                            <label class="form-label" for="reservation_no">Reservation No</label>
                                        </div>
                                        <div class="col-md-7 mb-3 mt-3">
                                            <div><?= @$reservation_no ?></div>
                                            <input type="hidden" name="reservation_no" value="<?= @$reservation_no ?>" id="reservation_no">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5 mb-3 mt-3">
                                            <label class="form-label" for="reservation_date">Reservation Date</label>
                                        </div>
                                        <div class="col-md-7 mb-3 mt-3">
                                            <?php
                                            $reservation_date = $row['event_date'];
                                            ?>
                                            <div><?= @$reservation_date ?></div>
                                            <input type="hidden" name="reservation_date" value="<?= @$reservation_date ?>" id="reservation_no">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label" for="event">Event</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql_event = "SELECT event_name FROM event WHERE event_id='" . $row['event_id'] . "'";
                                            $result_event = $db->query($sql_event);
                                            $row_event = $result_event->fetch_assoc();
                                            $event = $row_event['event_name'];
                                            ?>
                                            <div><?= @$event ?></div>
                                            <input type="hidden" name="event" value="<?= @$event ?>" id="event">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label" for="event">Selected Package</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql_package = "SELECT package_name FROM package WHERE package_id='" . $row['package_id'] . "'";
                                            $result_package = $db->query($sql_package);
                                            $row_package = $result_package->fetch_assoc();
                                            $package = $row_package['package_name'];
                                            ?>
                                            <div><?= @$package ?></div>
                                            <input type="hidden" name="package" value="<?= @$package ?>" id="package">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label" for="theme">Select a Theme</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <select name="theme" id="theme" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                <option value="">Select a Theme</option>
                                                <?php
                                                $db = dbConn();
                                                $sql_theme = "SELECT * FROM theme";
                                                $result_theme = $db->query($sql_theme);
                                                if ($result_theme->num_rows > 0) {
                                                    while ($row_theme = $result_theme->fetch_assoc()) {
                                                        ?>
                                                        <option value=<?= $row_theme['theme_id']; ?> <?php if ($row_theme['theme_id'] == @$theme) { ?> selected <?php } ?>><?= $row_theme['theme_name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="text-danger"><?= @$message["error_theme"] ?></div>
                                            <?php
                                            if (!empty($theme)) {
                                                $sql_theme_image = "SELECT sample_image FROM theme WHERE theme_id='$theme'";
                                                $result_theme_image = $db->query($sql_theme_image);
                                                $row_theme = $result_theme_image->fetch_assoc();
                                                ?>
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <p><strong><i>Sample Image</i></strong></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img src="../../system/assets/images/service_sample/<?= $row_theme['sample_image'] ?>" style="width:100px;height:100px;">
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    $db = dbConn();
                                    $sql_package_services = "SELECT service_id FROM package_services WHERE package_id='" . $row['package_id'] . "'";
                                    $result_package_services = $db->query($sql_package_services);
                                    $services_package = array();
                                    while ($row_package_services = $result_package_services->fetch_assoc()) {
                                        $services_package[] = $row_package_services['service_id'];
                                    }

                                    $sql_addon_services = "SELECT service_id FROM reservation_addon_service WHERE reservation_id='" . $row['reservation_id'] . "'";
                                    $result_addon_services = $db->query($sql_addon_services);
                                    $services_addon = array();
                                    while ($row_addon_services = $result_addon_services->fetch_assoc()) {
                                        $services_addon[] = $row_addon_services['service_id'];
                                    }
                                    echo 'package';
                                    var_dump($services_package);
                                    echo 'addon';
                                    var_dump($services_addon);
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php
                                            //echo '1st';
                                            //echo $value1 = in_array('28', $services_package);
                                            //echo '<br>2nd';
                                            //echo $value2 = in_array('28', $services_addon);
                                            if (in_array('9', $services_package) || in_array('9', $services_addon)) {
                                                ?>
                                                <div class="row mt-3">
                                                    <div class="col-md-5 mb-3">
                                                        <label class="form-label" for="poruwa_design">Poruwa Design</label>
                                                    </div>
                                                    <div class="col-md-7 mb-3">
                                                        <select name="poruwa_design" id="poruwa_design" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                            <option value="">Select a Sample</option>
                                                            <?php
                                                            $db = dbConn();
                                                            $sql_poruwa = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                    . "(SELECT sub_service_id FROM service WHERE service_id='9')";
                                                            $result_poruwa = $db->query($sql_poruwa);
                                                            if ($result_poruwa->num_rows > 0) {
                                                                while ($row_poruwa = $result_poruwa->fetch_assoc()) {
                                                                    ?>
                                                                    <option value=<?= $row_poruwa['service_sample_id'] ?> <?php if ($row_poruwa['service_sample_id'] == @$poruwa_design) { ?> selected <?php } ?>><?= $row_poruwa['sample_name'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger"><?= @$message["error_poruwa_design"] ?></div>
                                                        <?php
                                                        if (!empty($poruwa_design)) {
                                                            $sql_sample_image = "SELECT sample_image FROM service_samples WHERE service_sample_id='$poruwa_design'";
                                                            $result_sample_image = $db->query($sql_sample_image);
                                                            $row_sample = $result_sample_image->fetch_assoc();
                                                            ?>
                                                            <div class="row mt-2">
                                                                <div class="col-md-12">
                                                                    <p><strong><i>Sample Image</i></strong></p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            if (in_array('14', $services_package) || in_array('14', $services_addon)) {
                                                ?>
                                                <div class="row mt-3">
                                                    <div class="col-md-5 mb-3">
                                                        <label class="form-label" for="wedding_cake_design">Cake Structure</label>
                                                    </div>
                                                    <div class="col-md-7 mb-3">
                                                        <select name="wedding_cake_design" id="wedding_cake_design" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                            <option value="">Select a Sample</option>
                                                            <?php
                                                            $db = dbConn();
                                                            $sql_wedding_cake_design = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                    . "(SELECT sub_service_id FROM service WHERE service_id='14')";
                                                            $result_wedding_cake_design = $db->query($sql_wedding_cake_design);
                                                            if ($result_wedding_cake_design->num_rows > 0) {
                                                                while ($row_wedding_cake_design = $result_wedding_cake_design->fetch_assoc()) {
                                                                    ?>
                                                                    <option value=<?= $row_wedding_cake_design['service_sample_id'] ?> <?php if ($row_wedding_cake_design['service_sample_id'] == @$wedding_cake_design) { ?> selected <?php } ?>><?= $row_wedding_cake_design['sample_name'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger"><?= @$message["error_wedding_cake_design"] ?></div>
                                                        <?php
                                                        if (!empty($wedding_cake_design)) {
                                                            $sql_sample_image = "SELECT sample_image FROM service_samples WHERE service_sample_id='$wedding_cake_design'";
                                                            $result_sample_image = $db->query($sql_sample_image);
                                                            $row_sample = $result_sample_image->fetch_assoc();
                                                            ?>
                                                            <div class="row mt-2">
                                                                <div class="col-md-12">
                                                                    <p><strong><i>Sample Image</i></strong></p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            if (in_array('28', $services_package) || in_array('28', $services_addon)) {
                                                ?>
                                                <div class="row mt-3">
                                                    <div class="col-md-5 mb-3">
                                                        <label class="form-label" for="birthday_cake_design">Cake Structure</label>
                                                    </div>
                                                    <div class="col-md-7 mb-3">
                                                        <select name="birthday_cake_design" id="birthday_cake_design" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                            <option value="">Select a Sample</option>
                                                            <?php
                                                            $db = dbConn();
                                                            $sql_birthday_cake_design = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                    . "(SELECT sub_service_id FROM service WHERE service_id='28')";
                                                            $result_birthday_cake_design = $db->query($sql_birthday_cake_design);
                                                            if ($result_birthday_cake_design->num_rows > 0) {
                                                                while ($row_birthday_cake_design = $result_birthday_cake_design->fetch_assoc()) {
                                                                    ?>
                                                                    <option value=<?= $row_birthday_cake_design['service_sample_id'] ?> <?php if ($row_birthday_cake_design['service_sample_id'] == @$birthday_cake_design) { ?> selected <?php } ?>><?= $row_birthday_cake_design['sample_name'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger"><?= @$message["error_birthday_cake_design"] ?></div>
                                                        <?php
                                                        if (!empty($birthday_cake_design)) {
                                                            $sql_sample_image = "SELECT sample_image FROM service_samples WHERE service_sample_id='$birthday_cake_design'";
                                                            $result_sample_image = $db->query($sql_sample_image);
                                                            $row_sample = $result_sample_image->fetch_assoc();
                                                            ?>
                                                            <div class="row mt-2">
                                                                <div class="col-md-12">
                                                                    <p><strong><i>Sample Image</i></strong></p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            if (in_array('31', $services_package) || in_array('31', $services_addon)) {
                                                ?>
                                                <div class="row mt-3">
                                                    <div class="col-md-5 mb-3">
                                                        <label class="form-label" for="home_cake_design">Cake Structure</label>
                                                    </div>
                                                    <div class="col-md-7 mb-3">
                                                        <select name="home_cake_design" id="home_cake_design" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                            <option value="">Select a Sample</option>
                                                            <?php
                                                            $db = dbConn();
                                                            $sql_home_cake_design = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                    . "(SELECT sub_service_id FROM service WHERE service_id='31')";
                                                            $result_home_cake_design = $db->query($sql_home_cake_design);
                                                            if ($result_home_cake_design->num_rows > 0) {
                                                                while ($row_home_cake_design = $result_home_cake_design->fetch_assoc()) {
                                                                    ?>
                                                                    <option value=<?= $row_home_cake_design['service_sample_id'] ?> <?php if ($row_home_cake_design['service_sample_id'] == @$home_cake_design) { ?> selected <?php } ?>><?= $row_home_cake_design['sample_name'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger"><?= @$message["error_home_cake_design"] ?></div>
                                                        <?php
                                                        if (!empty($home_cake_design)) {
                                                            $sql_sample_image = "SELECT sample_image FROM service_samples WHERE service_sample_id='$home_cake_design'";
                                                            $result_sample_image = $db->query($sql_sample_image);
                                                            $row_sample = $result_sample_image->fetch_assoc();
                                                            ?>
                                                            <div class="row mt-2">
                                                                <div class="col-md-12">
                                                                    <p><strong><i>Sample Image</i></strong></p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            if (in_array('5', $services_package) || in_array('5', $services_addon)) {
                                                ?>
                                                <div class="row mt-3">
                                                    <div class="col-md-5 mb-3">
                                                        <label class="form-label" for="hall_design">Hall and Arch Decoration</label>
                                                    </div>
                                                    <div class="col-md-7 mb-3">
                                                        <select name="hall_design" id="hall_design" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                            <option value="">Select a Sample</option>
                                                            <?php
                                                            $db = dbConn();
                                                            $sql_hall_design = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                    . "(SELECT sub_service_id FROM service WHERE service_id='5')";
                                                            $result_hall_design = $db->query($sql_hall_design);
                                                            if ($result_hall_design->num_rows > 0) {
                                                                while ($row_hall_design = $result_hall_design->fetch_assoc()) {
                                                                    ?>
                                                                    <option value=<?= $row_hall_design['service_sample_id'] ?> <?php if ($row_hall_design['service_sample_id'] == @$hall_design) { ?> selected <?php } ?>><?= $row_hall_design['sample_name'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger"><?= @$message["error_hall_design"] ?></div>
                                                        <?php
                                                        if (!empty($hall_design)) {
                                                            $sql_sample_image = "SELECT sample_image FROM service_samples WHERE service_sample_id='$hall_design'";
                                                            $result_sample_image = $db->query($sql_sample_image);
                                                            $row_sample = $result_sample_image->fetch_assoc();
                                                            ?>
                                                            <div class="row mt-2">
                                                                <div class="col-md-12">
                                                                    <p><strong><i>Sample Image</i></strong></p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            if (in_array('8', $services_package) || in_array('8', $services_addon)) {
                                                ?>
                                                <div class="row mt-3">
                                                    <div class="col-md-5 mb-3">
                                                        <label class="form-label" for="fresh_flora">Fresh Floral Decoration</label>
                                                    </div>
                                                    <div class="col-md-7 mb-3">
                                                        <select name="fresh_flora" id="fresh_flora" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                            <option value="">Select a Sample</option>
                                                            <?php
                                                            $db = dbConn();
                                                            $sql_fresh_flora = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                    . "(SELECT sub_service_id FROM service WHERE service_id='8')";
                                                            $result_fresh_flora = $db->query($sql_fresh_flora);
                                                            if ($result_fresh_flora->num_rows > 0) {
                                                                while ($row_fresh_flora = $result_fresh_flora->fetch_assoc()) {
                                                                    ?>
                                                                    <option value=<?= $row_fresh_flora['service_sample_id'] ?> <?php if ($row_fresh_flora['service_sample_id'] == @$fresh_flora) { ?> selected <?php } ?>><?= $row_fresh_flora['sample_name'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger"><?= @$message["error_fresh_flora"] ?></div>
                                                        <?php
                                                        if (!empty($fresh_flora)) {
                                                            $sql_sample_image = "SELECT sample_image FROM service_samples WHERE service_sample_id='$fresh_flora'";
                                                            $result_sample_image = $db->query($sql_sample_image);
                                                            $row_sample = $result_sample_image->fetch_assoc();
                                                            ?>
                                                            <div class="row mt-2">
                                                                <div class="col-md-12">
                                                                    <p><strong><i>Sample Image</i></strong></p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            if (in_array('27', $services_package) || in_array('27', $services_addon)) {
                                                ?>
                                                <div class="row mt-3">
                                                    <div class="col-md-5 mb-3">
                                                        <label class="form-label" for="a_flora">Artificial Flora</label>
                                                    </div>
                                                    <div class="col-md-7 mb-3">
                                                        <select name="a_flora" id="a_flora" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                            <option value="">Select a Sample</option>
                                                            <?php
                                                            $db = dbConn();
                                                            $sql_a_flora = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                    . "(SELECT sub_service_id FROM service WHERE service_id='27')";
                                                            $result_a_flora = $db->query($sql_a_flora);
                                                            if ($result_a_flora->num_rows > 0) {
                                                                while ($row_a_flora = $result_a_flora->fetch_assoc()) {
                                                                    ?>
                                                                    <option value=<?= $row_a_flora['service_sample_id'] ?> <?php if ($row_a_flora['service_sample_id'] == @$a_flora) { ?> selected <?php } ?>><?= $row_a_flora['sample_name'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger"><?= @$message["error_a_flora"] ?></div>
                                                        <?php
                                                        if (!empty($a_flora)) {
                                                            $sql_sample_image = "SELECT sample_image FROM service_samples WHERE service_sample_id='$a_flora'";
                                                            $result_sample_image = $db->query($sql_sample_image);
                                                            $row_sample = $result_sample_image->fetch_assoc();
                                                            ?>
                                                            <div class="row mt-2">
                                                                <div class="col-md-12">
                                                                    <p><strong><i>Sample Image</i></strong></p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?php
                                            if (in_array('23', $services_package) || in_array('23', $services_addon)) {
                                                ?>
                                                <div class="row mt-3">
                                                    <div class="col-md-5 mb-3">
                                                        <label class="form-label" for="wedding_photo">Photography Package</label>
                                                    </div>
                                                    <div class="col-md-7 mb-3">
                                                        <select name="wedding_photo" id="wedding_photo" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                            <option value="">Select a Sample</option>
                                                            <?php
                                                            $db = dbConn();
                                                            $sql_wedding_photo = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                    . "(SELECT sub_service_id FROM service WHERE service_id='23')";
                                                            $result_wedding_photo = $db->query($sql_wedding_photo);
                                                            if ($result_wedding_photo->num_rows > 0) {
                                                                while ($row_wedding_photo = $result_wedding_photo->fetch_assoc()) {
                                                                    ?>
                                                                    <option value=<?= $row_wedding_photo['service_sample_id'] ?> <?php if ($row_wedding_photo['service_sample_id'] == @$wedding_photo) { ?> selected <?php } ?>><?= $row_wedding_photo['sample_name'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="text-danger"><?= @$message["error_wedding_photo"] ?></div>
                                                        <?php
                                                        if (!empty($wedding_photo)) {
                                                            $sql_sample_image = "SELECT sample_image FROM service_samples WHERE service_sample_id='$wedding_photo'";
                                                            $result_sample_image = $db->query($sql_sample_image);
                                                            $row_sample = $result_sample_image->fetch_assoc();
                                                            ?>
                                                            <div class="row mt-2">
                                                                <div class="col-md-12">
                                                                    <p><strong><i>Sample Image</i></strong></p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align:right">
                                    <button type="cancel" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;">Cancel</button>
                                    <button type="submit" name="action" value="request" class="btn btn-success btn-sm" style="font-size:13px;width:100px;">Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php include '../customer/footer.php'; ?>