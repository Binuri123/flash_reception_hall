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
    ?>
    <?php
    extract($_POST);
    $db = dbConn();
    $sql = "SELECT * FROM reservation WHERE reservation_no = '$reservation_no'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
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
//    echo 'package';
//    var_dump($services_package);
//    echo 'addon';
//    var_dump($services_addon);
//    var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'request') {
        //Required Field Validation
        $message = array();
        if (!empty($services_package) || !empty($services_addon)) {
            if (in_array('5', $services_package) || in_array('5', $services_addon)) {
                if (empty($hall_deco)) {
                    $message['error_hall_deco'] = "A Design Should be Selected...";
                }
            }
            if (in_array('7', $services_package) || in_array('7', $services_addon)) {
                if (empty($themed_deco)) {
                    $message['error_themed_deco'] = "A Theme Should be Selected...";
                }
            }
            if (in_array('8', $services_package) || in_array('8', $services_addon)) {
                if (empty($fresh_flora)) {
                    $message['error_fresh_flora'] = "A Design Should be Selected...";
                }
            }
            if (in_array('9', $services_package) || in_array('9', $services_addon)) {
                if (empty($poruwa)) {
                    $message['error_poruwa'] = "A Design Should be Selected...";
                }
            }
            if (in_array('14', $services_package) || in_array('14', $services_addon)) {
                if (empty($wed_cake)) {
                    $message['error_wed_cake'] = "A Structure Should be Selected...";
                }
            }
            if (in_array('23', $services_package) || in_array('23', $services_addon)) {
                if (empty($wed_photo)) {
                    $message['error_wed_photo'] = "A Package Should be Selected...";
                }
            }
            if (in_array('27', $services_package) || in_array('27', $services_addon)) {
                if (empty($a_flora)) {
                    $message['error_a_flora'] = "A Design Should be Selected...";
                }
            }
            if (in_array('28', $services_package) || in_array('28', $services_addon)) {
                if (empty($birth_cake)) {
                    $message['error_birth_cake'] = "A Structure Should be Selected...";
                }
            }
            if (in_array('30', $services_package) || in_array('30', $services_addon)) {
                if (empty($birth_photo)) {
                    $message['error_birth_photo'] = "A Package Should be Selected...";
                }
            }
            if (in_array('31', $services_package) || in_array('31', $services_addon)) {
                if (empty($home_cake)) {
                    $message['error_home_cake'] = "A Structure Should be Selected...";
                }
            }
            if (in_array('32', $services_package) || in_array('32', $services_addon)) {
                if (empty($ballon_deco)) {
                    $message['error_ballon_deco'] = "A Design Should be Selected...";
                }
            }
            if (in_array('34', $services_package) || in_array('34', $services_addon)) {
                if (empty($eng_photo)) {
                    $message['error_eng_photo'] = "A Package Should be Selected...";
                }
            }
        }

        //var_dump($message);
        if (empty($message)) {
            $db = dbConn();
            $sql = "SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'];
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $customer_no = $row['customer_no'];

            $cDate = date('Y-m-d');

            $sql = "INSERT INTO arrangement_plan(customer_no,reservation_no,arrangement_status_id,requested_date) "
                    . "VALUES('$customer_no','$reservation_no','1','$cDate')";
            $db->query($sql);

            $arr_plan_id = $db->insert_id;

            if (!empty($services_package) || !empty($services_addon)) {
                if (in_array('5', $services_package) || in_array('5', $services_addon)) {
                    if (!empty($hall_deco)) {
                        $sql = "INSERT INTO arrangement_plan_samples(arrangement_plan_id,service_id,service_sample_id) "
                                . "VALUES('$arr_plan_id','5','$hall_deco')";
                        $db->query($sql);
                    }
                }
                if (in_array('7', $services_package) || in_array('7', $services_addon)) {
                    if (!empty($themed_deco)) {
                        $sql = "INSERT INTO arrangement_plan_samples(arrangement_plan_id,service_id,service_sample_id) "
                                . "VALUES('$arr_plan_id','7','$themed_deco')";
                        $db->query($sql);
                    }
                }
                if (in_array('8', $services_package) || in_array('8', $services_addon)) {
                    if (!empty($fresh_flora)) {
                        $sql = "INSERT INTO arrangement_plan_samples(arrangement_plan_id,service_id,service_sample_id) "
                                . "VALUES('$arr_plan_id','8','$fresh_flora')";
                        $db->query($sql);
                    }
                }
                if (in_array('9', $services_package) || in_array('9', $services_addon)) {
                    if (!empty($poruwa)) {
                        $sql = "INSERT INTO arrangement_plan_samples(arrangement_plan_id,service_id,service_sample_id) "
                                . "VALUES('$arr_plan_id','9','$poruwa')";
                        $db->query($sql);
                    }
                }
                if (in_array('14', $services_package) || in_array('14', $services_addon)) {
                    if (!empty($wed_cake)) {
                        $sql = "INSERT INTO arrangement_plan_samples(arrangement_plan_id,service_id,service_sample_id) "
                                . "VALUES('$arr_plan_id','14','$wed_cake')";
                        $db->query($sql);
                    }
                }
                if (in_array('23', $services_package) || in_array('23', $services_addon)) {
                    if (!empty($wed_photo)) {
                        $sql = "INSERT INTO arrangement_plan_samples(arrangement_plan_id,service_id,service_sample_id) "
                                . "VALUES('$arr_plan_id','23','$wed_photo')";
                        $db->query($sql);
                    }
                }
                if (in_array('27', $services_package) || in_array('27', $services_addon)) {
                    if (!empty($a_flora)) {
                        $sql = "INSERT INTO arrangement_plan_samples(arrangement_plan_id,service_id,service_sample_id) "
                                . "VALUES('$arr_plan_id','27','$a_flora')";
                        $db->query($sql);
                    }
                }
                if (in_array('28', $services_package) || in_array('28', $services_addon)) {
                    if (!empty($birth_cake)) {
                        $sql = "INSERT INTO arrangement_plan_samples(arrangement_plan_id,service_id,service_sample_id) "
                                . "VALUES('$arr_plan_id','28','$birth_cake')";
                        $db->query($sql);
                    }
                }
                if (in_array('30', $services_package) || in_array('30', $services_addon)) {
                    if (!empty($birth_photo)) {
                        $sql = "INSERT INTO arrangement_plan_samples(arrangement_plan_id,service_id,service_sample_id) "
                                . "VALUES('$arr_plan_id','30','$birth_photo')";
                        $db->query($sql);
                    }
                }
                if (in_array('31', $services_package) || in_array('31', $services_addon)) {
                    if (!empty($home_cake)) {
                        $sql = "INSERT INTO arrangement_plan_samples(arrangement_plan_id,service_id,service_sample_id) "
                                . "VALUES('$arr_plan_id','31','$home_cake')";
                        $db->query($sql);
                    }
                }
                if (in_array('32', $services_package) || in_array('32', $services_addon)) {
                    if (!empty($ballon_deco)) {
                        $sql = "INSERT INTO arrangement_plan_samples(arrangement_plan_id,service_id,service_sample_id) "
                                . "VALUES('$arr_plan_id','32','$ballon_deco')";
                        $db->query($sql);
                    }
                }
                if (in_array('34', $services_package) || in_array('34', $services_addon)) {
                    if (!empty($eng_photo)) {
                        $sql = "INSERT INTO arrangement_plan_samples(arrangement_plan_id,service_id,service_sample_id) "
                                . "VALUES('$arr_plan_id','34','$eng_photo')";
                        $db->query($sql);
                    }
                }
            }
            header('location:arrangement_request_success.php?arr_plan_id=' . $arr_plan_id);
        }
    }
    ?>
    <section class="section dashboard">
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
                                <?php
                                if (!empty($services_package) || !empty($services_addon)) {
                                    ?>
                                    <?php
                                    if (in_array('5', $services_package) || in_array('5', $services_addon)) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="hall_deco">Hall and Arch Design</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <select name="hall_deco" id="hall_deco" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                        <option value="">Select a Sample</option>
                                                        <?php
                                                        $db = dbConn();
                                                        $sql_sub_service = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                . "(SELECT sub_service_id FROM service WHERE service_id='5') AND service_id='5'";
                                                        $result_sub_service = $db->query($sql_sub_service);
                                                        if ($result_sub_service->num_rows > 0) {
                                                            while ($row_sub_service = $result_sub_service->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row_sub_service['service_sample_id'] ?> <?php if ($row_sub_service['service_sample_id'] == @$hall_deco) { ?> selected <?php } ?>><?= $row_sub_service['sample_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger"><?= @$message["error_hall_deco"] ?></div>
                                                    <?php
                                                    if (!empty($hall_deco)) {
                                                        $sql_sample_image = "SELECT sample_image FROM service_samples WHERE service_sample_id='$hall_deco'";
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
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (in_array('7', $services_package) || in_array('7', $services_addon)) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="themed_deco">Decoration Theme</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <select name="themed_deco" id="themed_deco" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                        <option value="">Select a Sample</option>
                                                        <?php
                                                        $db = dbConn();
                                                        $sql_sub_service = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                . "(SELECT sub_service_id FROM service WHERE service_id='7') AND service_id='7'";
                                                        $result_sub_service = $db->query($sql_sub_service);
                                                        if ($result_sub_service->num_rows > 0) {
                                                            while ($row_sub_service = $result_sub_service->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row_sub_service['service_sample_id'] ?> <?php if ($row_sub_service['service_sample_id'] == @$themed_deco) { ?> selected <?php } ?>><?= $row_sub_service['sample_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger"><?= @$message["error_themed_deco"] ?></div>
                                                    <?php
                                                    if (!empty($themed_deco)) {
                                                        $sql_sample_image = "SELECT sample_image FROM service_samples WHERE service_sample_id='$themed_deco'";
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
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (in_array('8', $services_package) || in_array('8', $services_addon)) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="fresh_flora">Fresh Flower Decoration</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <select name="fresh_flora" id="fresh_flora" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                        <option value="">Select a Sample</option>
                                                        <?php
                                                        $db = dbConn();
                                                        $sql_sub_service = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                . "(SELECT sub_service_id FROM service WHERE service_id='8') AND service_id='8'";
                                                        $result_sub_service = $db->query($sql_sub_service);
                                                        if ($result_sub_service->num_rows > 0) {
                                                            while ($row_sub_service = $result_sub_service->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row_sub_service['service_sample_id'] ?> <?php if ($row_sub_service['service_sample_id'] == @$fresh_flora) { ?> selected <?php } ?>><?= $row_sub_service['sample_name'] ?></option>
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
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (in_array('9', $services_package) || in_array('9', $services_addon)) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="poruwa">Poruwa Design</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <select name="poruwa" id="poruwa" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                        <option value="">Select a Sample</option>
                                                        <?php
                                                        $db = dbConn();
                                                        $sql_sub_service = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                . "(SELECT sub_service_id FROM service WHERE service_id='9') AND service_id='9'";
                                                        $result_sub_service = $db->query($sql_sub_service);
                                                        if ($result_sub_service->num_rows > 0) {
                                                            while ($row_sub_service = $result_sub_service->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row_sub_service['service_sample_id'] ?> <?php if ($row_sub_service['service_sample_id'] == @$poruwa) { ?> selected <?php } ?>><?= $row_sub_service['sample_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger"><?= @$message["error_poruwa"] ?></div>
                                                    <?php
                                                    if (!empty($poruwa)) {
                                                        $sql_sample_image = "SELECT sample_image FROM service_samples "
                                                                . "WHERE service_sample_id='$poruwa'";
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
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (in_array('14', $services_package) || in_array('14', $services_addon)) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="wed_cake">Cake Structure</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <select name="wed_cake" id="wed_cake" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                        <option value="">Select a Sample</option>
                                                        <?php
                                                        $db = dbConn();
                                                        $sql_sub_service = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                . "(SELECT sub_service_id FROM service WHERE service_id='14') AND service_id='14'";
                                                        $result_sub_service = $db->query($sql_sub_service);
                                                        if ($result_sub_service->num_rows > 0) {
                                                            while ($row_sub_service = $result_sub_service->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row_sub_service['service_sample_id'] ?> <?php if ($row_sub_service['service_sample_id'] == @$wed_cake) { ?> selected <?php } ?>><?= $row_sub_service['sample_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger"><?= @$message["error_wed_cake"] ?></div>
                                                    <?php
                                                    if (!empty($wed_cake)) {
                                                        $sql_sample_image = "SELECT sample_image FROM service_samples "
                                                                . "WHERE service_sample_id='$wed_cake'";
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
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (in_array('23', $services_package) || in_array('23', $services_addon)) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="wed_photo">Photography Package</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <select name="wed_photo" id="wed_photo" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                        <option value="">Select a Sample</option>
                                                        <?php
                                                        $db = dbConn();
                                                        $sql_sub_service = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                . "(SELECT sub_service_id FROM service WHERE service_id='23') AND service_id='23'";
                                                        $result_sub_service = $db->query($sql_sub_service);
                                                        if ($result_sub_service->num_rows > 0) {
                                                            while ($row_sub_service = $result_sub_service->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row_sub_service['service_sample_id'] ?> <?php if ($row_sub_service['service_sample_id'] == @$wed_photo) { ?> selected <?php } ?>><?= $row_sub_service['sample_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger"><?= @$message["error_wed_photo"] ?></div>
                                                    <?php
                                                    if (!empty($wed_photo)) {
                                                        $sql_sample_image = "SELECT sample_image FROM service_samples "
                                                                . "WHERE service_sample_id='$wed_photo'";
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
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (in_array('27', $services_package) || in_array('27', $services_addon)) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="a_flora">Artificial Flower Decoration</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <select name="a_flora" id="a_flora" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                        <option value="">Select a Sample</option>
                                                        <?php
                                                        $db = dbConn();
                                                        $sql_sub_service = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                . "(SELECT sub_service_id FROM service WHERE service_id='27') AND service_id='27'";
                                                        $result_sub_service = $db->query($sql_sub_service);
                                                        if ($result_sub_service->num_rows > 0) {
                                                            while ($row_sub_service = $result_sub_service->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row_sub_service['service_sample_id'] ?> <?php if ($row_sub_service['service_sample_id'] == @$a_flora) { ?> selected <?php } ?>><?= $row_sub_service['sample_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger"><?= @$message["error_a_flora"] ?></div>
                                                    <?php
                                                    if (!empty($a_flora)) {
                                                        $sql_sample_image = "SELECT sample_image FROM service_samples "
                                                                . "WHERE service_sample_id='$a_flora'";
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
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (in_array('28', $services_package) || in_array('28', $services_addon)) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="birth_cake">Cake Structure</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <select name="birth_cake" id="birth_cake" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                        <option value="">Select a Sample</option>
                                                        <?php
                                                        $db = dbConn();
                                                        $sql_sub_service = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                . "(SELECT sub_service_id FROM service WHERE service_id='28') AND service_id='28'";
                                                        $result_sub_service = $db->query($sql_sub_service);
                                                        if ($result_sub_service->num_rows > 0) {
                                                            while ($row_sub_service = $result_sub_service->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row_sub_service['service_sample_id'] ?> <?php if ($row_sub_service['service_sample_id'] == @$birth_cake) { ?> selected <?php } ?>><?= $row_sub_service['sample_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger"><?= @$message["error_birth_cake"] ?></div>
                                                    <?php
                                                    if (!empty($birth_cake)) {
                                                        $sql_sample_image = "SELECT sample_image FROM service_samples "
                                                                . "WHERE service_sample_id='$birth_cake'";
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
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (in_array('30', $services_package) || in_array('30', $services_addon)) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="birth_photo">Photography Package</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <select name="birth_photo" id="birth_photo" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                        <option value="">Select a Sample</option>
                                                        <?php
                                                        $db = dbConn();
                                                        $sql_sub_service = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                . "(SELECT sub_service_id FROM service WHERE service_id='30') AND service_id='30'";
                                                        $result_sub_service = $db->query($sql_sub_service);
                                                        if ($result_sub_service->num_rows > 0) {
                                                            while ($row_sub_service = $result_sub_service->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row_sub_service['service_sample_id'] ?> <?php if ($row_sub_service['service_sample_id'] == @$birth_photo) { ?> selected <?php } ?>><?= $row_sub_service['sample_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger"><?= @$message["error_birth_photo"] ?></div>
                                                    <?php
                                                    if (!empty($birth_photo)) {
                                                        $sql_sample_image = "SELECT sample_image FROM service_samples "
                                                                . "WHERE service_sample_id='$birth_photo'";
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
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (in_array('31', $services_package) || in_array('31', $services_addon)) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="home_cake">Cake Structure</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <select name="home_cake" id="home_cake" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                        <option value="">Select a Sample</option>
                                                        <?php
                                                        $db = dbConn();
                                                        $sql_sub_service = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                . "(SELECT sub_service_id FROM service WHERE service_id='31') AND service_id='31'";
                                                        $result_sub_service = $db->query($sql_sub_service);
                                                        if ($result_sub_service->num_rows > 0) {
                                                            while ($row_sub_service = $result_sub_service->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row_sub_service['service_sample_id'] ?> <?php if ($row_sub_service['service_sample_id'] == @$home_cake) { ?> selected <?php } ?>><?= $row_sub_service['sample_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger"><?= @$message["error_home_cake"] ?></div>
                                                    <?php
                                                    if (!empty($home_cake)) {
                                                        $sql_sample_image = "SELECT sample_image FROM service_samples "
                                                                . "WHERE service_sample_id='$home_cake'";
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
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (in_array('32', $services_package) || in_array('32', $services_addon)) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="ballon_deco">Balloon Decorations</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <select name="ballon_deco" id="ballon_deco" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                        <option value="">Select a Sample</option>
                                                        <?php
                                                        $db = dbConn();
                                                        $sql_sub_service = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                . "(SELECT sub_service_id FROM service WHERE service_id='32') AND service_id='32'";
                                                        $result_sub_service = $db->query($sql_sub_service);
                                                        if ($result_sub_service->num_rows > 0) {
                                                            while ($row_sub_service = $result_sub_service->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row_sub_service['service_sample_id'] ?> <?php if ($row_sub_service['service_sample_id'] == @$ballon_deco) { ?> selected <?php } ?>><?= $row_sub_service['sample_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger"><?= @$message["error_ballon_deco"] ?></div>
                                                    <?php
                                                    if (!empty($ballon_deco)) {
                                                        $sql_sample_image = "SELECT sample_image FROM service_samples "
                                                                . "WHERE service_sample_id='$ballon_deco'";
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
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (in_array('34', $services_package) || in_array('34', $services_addon)) {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="eng_photo">Photography Package</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <select name="eng_photo" id="eng_photo" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                        <option value="">Select a Sample</option>
                                                        <?php
                                                        $db = dbConn();
                                                        $sql_sub_service = "SELECT * FROM service_samples WHERE sub_service_id="
                                                                . "(SELECT sub_service_id FROM service WHERE service_id='34') AND service_id='34'";
                                                        $result_sub_service = $db->query($sql_sub_service);
                                                        if ($result_sub_service->num_rows > 0) {
                                                            while ($row_sub_service = $result_sub_service->fetch_assoc()) {
                                                                ?>
                                                                <option value=<?= $row_sub_service['service_sample_id'] ?> <?php if ($row_sub_service['service_sample_id'] == @$eng_photo) { ?> selected <?php } ?>><?= $row_sub_service['sample_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="text-danger"><?= @$message["error_eng_photo"] ?></div>
                                                    <?php
                                                    if (!empty($eng_photo)) {
                                                        $sql_sample_image = "SELECT sample_image FROM service_samples "
                                                                . "WHERE service_sample_id='$eng_photo'";
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
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                }
                                ?>
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