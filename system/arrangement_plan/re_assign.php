<?php
ob_start();
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="mt-3 pagetitle">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <h1 class="h4 m-0">Arrangement Plans</h1>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>arrangement_plan/arrangement_plan.php">Arrangement Plans</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>arrangement_plan/in_progress.php">In Progress</a></li>
                <li class="breadcrumb-item active" aria-current="page">Complete/Re Assignment</li>
            </ol>
        </nav>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
    }
    ?>
    <?php
    extract($_POST);
    $db = dbConn();
    $sql = "SELECT * FROM arrangement_plan WHERE arrangement_plan_id = '$arr_plan_id'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $sql_res = "SELECT * FROM reservation WHERE reservation_no = "
            . "(SELECT reservation_no FROM arrangement_plan WHERE arrangement_plan_id = '$arr_plan_id')";
    $result_res = $db->query($sql_res);
    $row_res = $result_res->fetch_assoc();

    //Get Services on Package
    $sql_package_services = "SELECT service_id FROM package_services WHERE package_id='" . $row_res['package_id'] . "'";
    $result_package_services = $db->query($sql_package_services);
    $services_package = array();
    while ($row_package_services = $result_package_services->fetch_assoc()) {
        $services_package[] = $row_package_services['service_id'];
    }

//Get Services on Requested as Add-on
    $sql_addon_services = "SELECT service_id FROM reservation_addon_service WHERE reservation_id='" . $row_res['reservation_id'] . "'";
    $result_addon_services = $db->query($sql_addon_services);
    $services_addon = array();
    while ($row_addon_services = $result_addon_services->fetch_assoc()) {
        $services_addon[] = $row_addon_services['service_id'];
    }
    
    $sql_con_count = "SELECT count(*) as services FROM arr_assign_supplier WHERE arr_plan_id='$arr_plan_id' AND assign_status_id='2'";
    $result_con_count = $db->query($sql_con_count);
    $row_con_count = $result_con_count->fetch_assoc();
    $x = $row_con_count['services'];

    $sql_all_count = "SELECT COUNT(DISTINCT service_id) as services FROM `arr_assign_supplier` WHERE arr_plan_id='$arr_plan_id'";
    $result_all_count = $db->query($sql_all_count);
    $row_all_count = $result_all_count->fetch_assoc();
    $y = $row_all_count['services'];

    //Get Out-sourcced Services
    $sql_reject = "SELECT service_id FROM arr_assign_supplier "
    . "WHERE arr_plan_id='$arr_plan_id' AND assign_status_id='3' "
    . "AND arr_assign_supplier_id IN (SELECT arr_assign_supplier_id "
    . "FROM arr_assign_supplier WHERE arr_plan_id='$arr_plan_id')";
    $result_reject = $db->query($sql_reject);
    $services_reject = array();
    while ($row_reject = $result_reject->fetch_assoc()) {
        $services_reject[] = $row_reject['service_id'];
    }

    $sql_confirmed = "SELECT service_id FROM arr_assign_supplier WHERE arr_plan_id='$arr_plan_id' "
            . "AND assign_status_id='2'";
    $result_confirmed = $db->query($sql_confirmed);
    $services_confirmed = array();
    while ($row_confirmed = $result_confirmed->fetch_assoc()) {
        $services_confirmed[] = $row_confirmed['service_id'];
    }
//    echo 'package';
//    var_dump($services_package);
//    echo 'addon';
//    var_dump($services_addon);
//    echo 'out';
//    var_dump($services_out);
//    var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'complete') {
        $db = dbConn();
        $cDate = date('Y-m-d');

        $sql = "UPDATE arrangement_plan SET arrangement_status_id='3',completed_date='$cDate' WHERE arrangement_plan_id='$arr_plan_id'";
        $db->query($sql);

        header('location:arr_complete_success.php?arr_plan_id=' . $arr_plan_id);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'reassign') {
        //Required Field Validation
        $message = array();
        if (!empty($services_reject)) {

            if (in_array('2', $services_reject)) {
                if (empty($dj_supplier)) {
                    $message['error_dj_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('3', $services_reject)) {
                if (empty($band_supplier)) {
                    $message['error_band_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('4', $services_reject)) {
                if (empty($tra_dance_supplier)) {
                    $message['error_tra_dance_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('5', $services_package) || in_array('5', $services_addon)) {
                if (empty($hall_deco_supplier)) {
                    $message['error_hall_deco_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('8', $services_reject)) {
                if (empty($fresh_flo_supplier)) {
                    $message['error_fresh_flo_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('9', $services_reject)) {
                if (empty($poruwa_supplier)) {
                    $message['error_poruwa_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('10', $services_reject)) {
                if (empty($astaka_6_supplier)) {
                    $message['error_astaka_6_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('11', $services_reject)) {
                if (empty($astaka_8_supplier)) {
                    $message['error_astaka_8_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('12', $services_reject)) {
                if (empty($j_gatha_supplier)) {
                    $message['error_j_gatha_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('13', $services_reject)) {
                if (empty($milk_fount_supplier)) {
                    $message['error_milk_fount_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('14', $services_reject)) {
                if (empty($wed_cake_supplier)) {
                    $message['error_wed_cake_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('15', $services_reject)) {
                if (empty($choc_fount_supplier)) {
                    $message['error_choc_fount_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('17', $services_reject)) {
                if (empty($oil_lamp_supplier)) {
                    $message['error_oil_lamp_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('18', $services_reject)) {
                if (empty($setteback_supplier)) {
                    $message['error_setteback_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('23', $services_reject)) {
                if (empty($wed_photo_supplier)) {
                    $message['error_wed_photo_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('25', $services_reject)) {
                if (empty($ice_carve_supplier)) {
                    $message['error_ice_carve_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('26', $services_reject)) {
                if (empty($cham_fount_supplier)) {
                    $message['error_cham_fount_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('27', $services_reject)) {
                if (empty($a_flora_supplier)) {
                    $message['error_a_flora_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('28', $services_reject)) {
                if (empty($birth_cake_supplier)) {
                    $message['error_birth_cake_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('29', $services_reject)) {
                if (empty($event_photo_supplier)) {
                    $message['error_event_photo_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('30', $services_reject)) {
                if (empty($birth_photo_supplier)) {
                    $message['error_birth_photo_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('31', $services_reject)) {
                if (empty($home_cake_supplier)) {
                    $message['error_home_cake_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('33', $services_reject)) {
                if (empty($candle_deco_supplier)) {
                    $message['error_candle_deco_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('32', $services_reject)) {
                if (empty($ballon_deco_supplier)) {
                    $message['error_ballon_deco_supplier'] = "A Supplier Should be Selected...";
                }
            }
            if (in_array('34', $services_reject)) {
                if (empty($eng_photo_supplier)) {
                    $message['error_eng_photo_supplier'] = "A Supplier Should be Selected...";
                }
            }
        }

        //var_dump($message);
        if (empty($message)) {
            $cDate = date('Y-m-d');
            if (!empty($services_reject)) {

                if (in_array('2', $services_reject)) {
                    if (!empty($dj_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','2','$dj_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('3', $services_reject)) {
                    if (!empty($band_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','3','$band_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('4', $services_reject)) {
                    if (!empty($tra_dance_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','4','$tra_dance_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('5', $services_reject)) {
                    if (!empty($hall_deco_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','5','$hall_deco_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('8', $services_reject)) {
                    if (!empty($fresh_flo_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','8','$fresh_flo_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('9', $services_reject)) {
                    if (!empty($poruwa_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','9','$poruwa_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('10', $services_reject)) {
                    if (!empty($astaka_6_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','10','$astaka_6_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('11', $services_reject)) {
                    if (!empty($astaka_8_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','11','$astaka_8_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('12', $services_reject)) {
                    if (!empty($j_gatha_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','12','$j_gatha_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('13', $services_reject)) {
                    if (!empty($milk_fount_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','13','$milk_fount_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('14', $services_reject)) {
                    if (!empty($wed_cake_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','14','$wed_cake_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('15', $services_reject)) {
                    if (!empty($choc_fount_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','15','$choc_fount_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('17', $services_reject)) {
                    if (!empty($oil_lamp_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','17','$oil_lamp_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('18', $services_reject)) {
                    if (!empty($setteback_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','18','$setteback_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('23', $services_reject)) {
                    if (!empty($wed_photo_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','23','$wed_photo_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('25', $services_reject)) {
                    if (!empty($ice_carve_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','25','$ice_carve_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('26', $services_reject)) {
                    if (!empty($cham_fount_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','26','$cham_fount_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('27', $services_reject)) {
                    if (!empty($a_flora_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','27','$a_flora_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('28', $services_reject)) {
                    if (!empty($birth_cake_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','28','$birth_cake_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('29', $services_reject)) {
                    if (!empty($event_photo_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','29','$event_photo_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('30', $services_reject)) {
                    if (!empty($birth_photo_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','30','$birth_photo_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('31', $services_reject)) {
                    if (!empty($home_cake_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','31','$home_cake_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('33', $services_reject)) {
                    if (!empty($candle_deco_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','33','$candle_deco_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('32', $services_reject)) {
                    if (!empty($ballon_deco_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','32','$ballon_deco_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
                if (in_array('34', $services_reject)) {
                    if (!empty($eng_photo_supplier)) {
                        $sql = "INSERT INTO arr_assign_supplier(arr_plan_id,service_id,supplier_id,assign_status_id,assign_date) "
                                . "VALUES('$arr_plan_id','34','$eng_photo_supplier','1','$cDate')";
                        $db->query($sql);
                    }
                }
            }

            header('location:arr_reassign_success.php?arr_plan_id=' . $arr_plan_id);
        }
    }
    ?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <div class="card bg-light" style="font-size:13px;">
                <div class="card-header">
                    <h3>Assign Suppliers</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-5 mt-3">
                                        <label class="form-label" for="reservation_no">Reservation No</label>
                                    </div>
                                    <div class="col-md-7 mt-3">
                                        <div><?= $row_res['reservation_no'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-5 mt-3">
                                        <label class="form-label" for="reservation_date">Reservation Date</label>
                                    </div>
                                    <div class="col-md-7 mt-3">
                                        <div><?= $row_res['event_date'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="form-label" for="event">Event</label>
                                    </div>
                                    <div class="col-md-7">
                                        <?php
                                        $db = dbConn();
                                        $sql_event = "SELECT event_name FROM event WHERE event_id='" . $row_res['event_id'] . "'";
                                        $result_event = $db->query($sql_event);
                                        $row_event = $result_event->fetch_assoc();
                                        $event = $row_event['event_name'];
                                        ?>
                                        <div><?= @$event ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="form-label" for="event">Selected Package</label>
                                    </div>
                                    <div class="col-md-7">
                                        <?php
                                        $db = dbConn();
                                        $sql_package = "SELECT package_name FROM package WHERE package_id='" . $row_res['package_id'] . "'";
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
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label" for="hall_deco">Hall and Arch Design</label>
                                            </div>
                                            <div class="col-md-7">
                                                <?php
                                                $sql_sample_image = "SELECT sample_name,sample_image "
                                                        . "FROM service_samples WHERE service_sample_id="
                                                        . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                        . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='5')";
                                                $result_sample_image = $db->query($sql_sample_image);
                                                $row_sample = $result_sample_image->fetch_assoc();
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                    </div>
                                                </div>
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
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label" for="themed_deco">Decoration Theme</label>
                                            </div>
                                            <div class="col-md-7">
                                                <?php
                                                $sql_sample_image = "SELECT sample_name,sample_image "
                                                        . "FROM service_samples WHERE service_sample_id="
                                                        . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                        . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='7')";
                                                $result_sample_image = $db->query($sql_sample_image);
                                                $row_sample = $result_sample_image->fetch_assoc();
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                    </div>
                                                </div>
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
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label" for="fresh_flora">Fresh Flower Decoration</label>
                                            </div>
                                            <div class="col-md-7">
                                                <?php
                                                $sql_sample_image = "SELECT sample_name,sample_image "
                                                        . "FROM service_samples WHERE service_sample_id="
                                                        . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                        . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='8')";
                                                $result_sample_image = $db->query($sql_sample_image);
                                                $row_sample = $result_sample_image->fetch_assoc();
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                    </div>
                                                </div>
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
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label" for="poruwa">Poruwa Design</label>
                                            </div>
                                            <div class="col-md-7">
                                                <?php
                                                $sql_sample_image = "SELECT sample_name,sample_image "
                                                        . "FROM service_samples WHERE service_sample_id="
                                                        . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                        . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='9')";
                                                $result_sample_image = $db->query($sql_sample_image);
                                                $row_sample = $result_sample_image->fetch_assoc();
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                    </div>
                                                </div>
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
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label" for="wed_cake">Cake Structure</label>
                                            </div>
                                            <div class="col-md-7">
                                                <?php
                                                $sql_sample_image = "SELECT sample_name,sample_image "
                                                        . "FROM service_samples WHERE service_sample_id="
                                                        . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                        . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='14')";
                                                $result_sample_image = $db->query($sql_sample_image);
                                                $row_sample = $result_sample_image->fetch_assoc();
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                    </div>
                                                </div>
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
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label" for="wed_photo">Photography Package</label>
                                            </div>
                                            <div class="col-md-7">
                                                <?php
                                                $sql_sample_image = "SELECT sample_name,sample_image "
                                                        . "FROM service_samples WHERE service_sample_id="
                                                        . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                        . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='23')";
                                                $result_sample_image = $db->query($sql_sample_image);
                                                $row_sample = $result_sample_image->fetch_assoc();
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                    </div>
                                                </div>
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
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label" for="a_flora">Artificial Flower Decoration</label>
                                            </div>
                                            <div class="col-md-7">
                                                <?php
                                                $sql_sample_image = "SELECT sample_name,sample_image "
                                                        . "FROM service_samples WHERE service_sample_id="
                                                        . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                        . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='27')";
                                                $result_sample_image = $db->query($sql_sample_image);
                                                $row_sample = $result_sample_image->fetch_assoc();
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                    </div>
                                                </div>
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
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label" for="birth_cake">Cake Structure</label>
                                            </div>
                                            <div class="col-md-7">
                                                <?php
                                                $sql_sample_image = "SELECT sample_name,sample_image "
                                                        . "FROM service_samples WHERE service_sample_id="
                                                        . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                        . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='28')";
                                                $result_sample_image = $db->query($sql_sample_image);
                                                $row_sample = $result_sample_image->fetch_assoc();
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                    </div>
                                                </div>
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
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label" for="birth_photo">Photography Package</label>
                                            </div>
                                            <div class="col-md-7">
                                                <?php
                                                $sql_sample_image = "SELECT sample_name,sample_image "
                                                        . "FROM service_samples WHERE service_sample_id="
                                                        . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                        . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='30')";
                                                $result_sample_image = $db->query($sql_sample_image);
                                                $row_sample = $result_sample_image->fetch_assoc();
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                    </div>
                                                </div>
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
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label" for="home_cake">Cake Structure</label>
                                            </div>
                                            <div class="col-md-7">
                                                <?php
                                                $sql_sample_image = "SELECT sample_name,sample_image "
                                                        . "FROM service_samples WHERE service_sample_id="
                                                        . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                        . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='31')";
                                                $result_sample_image = $db->query($sql_sample_image);
                                                $row_sample = $result_sample_image->fetch_assoc();
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                    </div>
                                                </div>
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
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label" for="ballon_deco">Balloon Decorations</label>
                                            </div>
                                            <div class="col-md-7">
                                                <?php
                                                $sql_sample_image = "SELECT sample_name,sample_image "
                                                        . "FROM service_samples WHERE service_sample_id="
                                                        . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                        . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='32')";
                                                $result_sample_image = $db->query($sql_sample_image);
                                                $row_sample = $result_sample_image->fetch_assoc();
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                    </div>
                                                </div>
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
                                        <div class="row">
                                            <div class="col-md-5">
                                                <label class="form-label" for="eng_photo">Photography Package</label>
                                            </div>
                                            <div class="col-md-7">
                                                <?php
                                                $sql_sample_image = "SELECT sample_name,sample_image "
                                                        . "FROM service_samples WHERE service_sample_id="
                                                        . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                        . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='34')";
                                                $result_sample_image = $db->query($sql_sample_image);
                                                $row_sample = $result_sample_image->fetch_assoc();
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                    </div>
                                                </div>
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
                            <h5>Assign Suppliers</h5>
                        </div>
                        <div class="row">
                            <?php
                            if (!empty($services_package) || !empty($services_addon)) {
                                ?>
                                <?php
                                if (($x != $y) && (in_array('2', $services_package) || in_array('2', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="dj_supplier">DJ Music</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="dj_supplier" id="dj_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='2') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='2')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$dj_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_dj_supplier"] ?></div>
                                                <?php
                                                if (!empty($dj_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('2', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="dj_supplier">DJ Music</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='2' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('3', $services_package) || in_array('3', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="band_supplier">Band Group</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="band_supplier" id="band_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='3') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='3')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$band_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_band_supplier"] ?></div>
                                                <?php
                                                if (!empty($band_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('3', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="band_supplier">Band Group</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='3' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('4', $services_package) || in_array('4', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="tra_dance_supplier">Traditional Dancing Group</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="tra_dance_supplier" id="tra_dance_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='4') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='4')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$tra_dance_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_tra_dance_supplier"] ?></div>
                                                <?php
                                                if (!empty($tra_dance_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('4', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="tra_dance_supplier">Traditional Dancing Group</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='4' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('5', $services_package) || in_array('5', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="hall_deco_supplier">Hall and Arch Decorations</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="hall_deco_supplier" id="hall_deco_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='5') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='5')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$hall_deco_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_hall_deco_supplier"] ?></div>
                                                <?php
                                                if (!empty($hall_deco_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('5', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="hall_deco_supplier">Hall and Arch Decorations</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='5' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('8', $services_package) || in_array('8', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="fresh_flo_supplier">Fresh Flowers</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="fresh_flo_supplier" id="fresh_flo_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='8') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='8')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$fresh_flo_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_fresh_flo_supplier"] ?></div>
                                                <?php
                                                if (!empty($fresh_flo_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('8', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="fresh_flo_supplier">Fresh Flowers</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='8' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('9', $services_package) || in_array('9', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="poruwa_supplier">Poruwa</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="poruwa_supplier" id="poruwa_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='9') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='9')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$poruwa_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_poruwa_supplier"] ?></div>
                                                <?php
                                                if (!empty($poruwa_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('9', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="poruwa_supplier">Poruwa</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='9' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('10', $services_package) || in_array('10', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="astaka_6_supplier">Ashtaka Group of 6</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="astaka_6_supplier" id="astaka_6_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='10') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='10')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$astaka_6_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_astaka_6_supplier"] ?></div>
                                                <?php
                                                if (!empty($astaka_6_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('10', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="astaka_6_supplier">Ashtaka Group of 6</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='10' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('11', $services_package) || in_array('11', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="astaka_8_supplier">Ashtaka Group of 8</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="astaka_8_supplier" id="astaka_8_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='11') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='11')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$astaka_8_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_astaka_8_supplier"] ?></div>
                                                <?php
                                                if (!empty($astaka_8_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('11', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="astaka_8_supplier">Ashtaka Group of 8</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='11' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('12', $services_package) || in_array('12', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="j_gatha_supplier">Jayamangala Gatha</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="j_gatha_supplier" id="j_gatha_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='12') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='12')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$j_gatha_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_j_gatha_supplier"] ?></div>
                                                <?php
                                                if (!empty($j_gatha_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('12', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="j_gatha_supplier">Jayamangala Gatha</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='12' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('13', $services_package) || in_array('13', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="milk_fount_supplier">Milk Fountain</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="milk_fount_supplier" id="milk_fount_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='13') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='13')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$milk_fount_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_milk_fount_supplier"] ?></div>
                                                <?php
                                                if (!empty($milk_fount_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('13', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="milk_fount_supplier">Milk Fountain</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='13' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('14', $services_package) || in_array('14', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="wed_cake_supplier">Wedding Cake Structure</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="wed_cake_supplier" id="wed_cake_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='14') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='14')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$wed_cake_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_wed_cake_supplier"] ?></div>
                                                <?php
                                                if (!empty($wed_cake_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('14', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="wed_cake_supplier">Wedding Cake Structure</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='14' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('15', $services_package) || in_array('15', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="choc_fount_supplier">Chocolate Fountain</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="choc_fount_supplier" id="choc_fount_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='15') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='15')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$choc_fount_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_choc_fount_supplier"] ?></div>
                                                <?php
                                                if (!empty($choc_fount_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('15', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="choc_fount_supplier">Chocolate Fountain</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='15' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('17', $services_package) || in_array('17', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="oil_lamp_supplier">Oil Lamp</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="oil_lamp_supplier" id="oil_lamp_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='17') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='17')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$oil_lamp_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_oil_lamp_supplier"] ?></div>
                                                <?php
                                                if (!empty($oil_lamp_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('17', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="oil_lamp_supplier">Oil Lamp</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='17' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('18', $services_package) || in_array('18', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="setteback_supplier">Setteback</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="setteback_supplier" id="setteback_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='18') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='18')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$setteback_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_setteback_supplier"] ?></div>
                                                <?php
                                                if (!empty($setteback_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('18', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="setteback_supplier">Setteback</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='18' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('23', $services_package) || in_array('23', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="wed_photo_supplier">Wedding Photographer</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="wed_photo_supplier" id="wed_photo_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='23') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='23')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$wed_photo_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_wed_photo_supplier"] ?></div>
                                                <?php
                                                if (!empty($wed_photo_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('23', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="wed_photo_supplier">Wedding Photographer</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='23' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && (in_array('25', $services_package) || in_array('25', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="ice_carve_supplier">Ice Carving</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="ice_carve_supplier" id="ice_carve_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='25') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='25')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$ice_carve_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_ice_carve_supplier"] ?></div>
                                                <?php
                                                if (!empty($ice_carve_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('25', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="ice_carve_supplier">Ice Carving</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='25' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && in_array('26',$services_reject) && (in_array('26', $services_package) || in_array('26', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="cham_fount_supplier">Champagne Fountain</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="cham_fount_supplier" id="cham_fount_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='26') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='26')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$cham_fount_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_cham_fount_supplier"] ?></div>
                                                <?php
                                                if (!empty($cham_fount_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('26', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="cham_fount_supplier">Champagne Fountain</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='26' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && in_array('27',$services_reject) && (in_array('27', $services_package) || in_array('27', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="a_flora_supplier">Artificial Flower Decorations</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="a_flora_supplier" id="a_flora_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='27') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='27')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$a_flora_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_a_flora_supplier"] ?></div>
                                                <?php
                                                if (!empty($a_flora_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('27', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="a_flora_supplier">Artificial Flower Decorations</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='27' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && in_array('28',$services_reject)  && (in_array('28', $services_package) || in_array('28', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="birth_cake_supplier">Birthday Cake Structure</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="birth_cake_supplier" id="birth_cake_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='28') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='28')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$birth_cake_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_birth_cake_supplier"] ?></div>
                                                <?php
                                                if (!empty($birth_cake_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('28', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="birth_cake_supplier">Birthday Cake Structure</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='28' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && in_array('29',$services_reject)  && (in_array('29', $services_package) || in_array('29', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="event_photo_supplier">Event Photographer</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="event_photo_supplier" id="event_photo_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='29') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='29')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$event_photo_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_event_photo_supplier"] ?></div>
                                                <?php
                                                if (!empty($event_photo_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('29', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="event_photo_supplier">Event Photographer</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='29' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && in_array('30',$services_reject)  && (in_array('30', $services_package) || in_array('30', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="birth_photo_supplier">Birthday Photographer</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="birth_photo_supplier" id="birth_photo_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='30') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='30')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$birth_photo_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_birth_photo_supplier"] ?></div>
                                                <?php
                                                if (!empty($birth_photo_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('30', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="birth_photo_supplier">Birthday Photographer</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='30' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && in_array('31',$services_reject)  && (in_array('31', $services_package) || in_array('31', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="home_cake_supplier">Homecoming Cake Structure</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="home_cake_supplier" id="home_cake_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='31') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='31')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$home_cake_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_home_cake_supplier"] ?></div>
                                                <?php
                                                if (!empty($home_cake_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('31', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="home_cake_supplier">Homecoming Cake Structure</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='31' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && in_array('33',$services_reject)  && (in_array('33', $services_package) || in_array('33', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="candle_deco_supplier">Candle Decorations</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="candle_deco_supplier" id="candle_deco_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='33') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='33')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$candle_deco_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_candle_deco_supplier"] ?></div>
                                                <?php
                                                if (!empty($candle_deco_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('33', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="candle_deco_supplier">Candle Decorations</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='33' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && in_array('32',$services_reject)  && (in_array('32', $services_package) || in_array('32', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="ballon_deco_supplier">Balloon Decoration</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="ballon_deco_supplier" id="ballon_deco_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='32') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='32')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$ballon_deco_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_ballon_deco_supplier"] ?></div>
                                                <?php
                                                if (!empty($ballon_deco_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('32', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="ballon_deco_supplier">Balloon Decoration</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='32' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($x != $y) && in_array('34',$services_reject) && (in_array('34', $services_package) || in_array('34', $services_addon))) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="eng_photo_supplier">Engagement Photographer</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <select name="eng_photo_supplier" id="eng_photo_supplier" class="form-control form-select" style="font-size:12px;" onchange="form.submit()">
                                                    <option value="">Select a Supplier</option>
                                                    <?php
                                                    $db = dbConn();
                                                    $sql_supplier = "SELECT supplier_id,company_name FROM supplier "
                                                            . "WHERE supplier_id IN "
                                                            . "(SELECT supplier_id FROM supplier_service "
                                                            . "WHERE service_id='34') AND supplier_id "
                                                            . "NOT IN (SELECT supplier_id FROM arr_assign_supplier "
                                                            . "WHERE assign_status_id='3' AND arr_plan_id='$arr_plan_id' AND service_id='34')";
                                                    $result_supplier = $db->query($sql_supplier);
                                                    if ($result_supplier->num_rows > 0) {
                                                        while ($row_supplier = $result_supplier->fetch_assoc()) {
                                                            ?>
                                                            <option value=<?= $row_supplier['supplier_id'] ?> <?php if ($row_supplier['supplier_id'] == @$eng_photo_supplier) { ?> selected <?php } ?>><?= $row_supplier['company_name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="text-danger"><?= @$message["error_eng_photo_supplier"] ?></div>
                                                <?php
                                                if (!empty($eng_photo_supplier)) {
                                                    $sql_con_status = "SELECT assignment_status FROM supplier_assignment_status WHERE assignment_id='1'";
                                                    $result_con_status = $db->query($sql_con_status);
                                                    $row_con_status = $result_con_status->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_con_status['assignment_status'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } elseif (in_array('34', $services_confirmed)) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="row mt-3">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label" for="eng_photo_supplier">Engagement Photographer</label>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <?php
                                                $db = dbConn();
                                                $sql_supplier = "SELECT company_name FROM supplier "
                                                        . "WHERE supplier_id IN "
                                                        . "(SELECT supplier_id FROM arr_assign_supplier "
                                                        . "WHERE arr_plan_id = '$arr_plan_id' "
                                                        . "AND service_id='34' AND assign_status_id = '2')";
                                                $result_supplier = $db->query($sql_supplier);
                                                $row_supplier = $result_supplier->fetch_assoc();
                                                ?>
                                                <p><strong><i><?= $row_supplier['company_name'] ?> - Confirmed</i></strong></p>
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
                                <input type="hidden" name="arr_plan_id" value="<?= @$arr_plan_id ?>">
                                <?php
                                if ($x != $y) {
                                    ?>
                                    <button type="submit" name="action" value="reassign" style="width:100px;font-size:13px;" class="btn btn-sm btn-warning">Re Assign</button>
                                    <?php
                                } else {
                                    ?>
                                    <button type="submit" name="action" value="complete" style="width:100px;font-size:13px;" class="btn btn-sm btn-success">Complete</button>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</main>

<?php
include '../footer.php';
ob_end_flush();
?>
