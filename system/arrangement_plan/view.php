<?php
include '../header.php';
include '../menu.php';
include '../assets/phpmail/mail.php';
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
                <li class="breadcrumb-item active" aria-current="page">View</li>
            </ol>
        </nav>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        extract($_GET);
    }

    $db = dbConn();
    $sql = "SELECT * FROM arrangement_plan WHERE arrangement_plan_id = '$arr_plan_id'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $sql_res = "SELECT * FROM reservation WHERE reservation_no = "
            . "(SELECT reservation_no FROM arrangement_plan WHERE arrangement_plan_id = '$arr_plan_id')";
    $result_res = $db->query($sql_res);
    $row_res = $result_res->fetch_assoc();

    $sql_res_event = "SELECT event_name FROM event WHERE event_id='" . $row_res['event_id'] . "'";
    $result_res_event = $db->query($sql_res_event);
    $row_res_event = $result_res_event->fetch_assoc();
    
    $sql_res_hall = "SELECT hall_name FROM hall WHERE hall_id='" . $row_res['hall_id'] . "'";
    $result_res_hall = $db->query($sql_res_hall);
    $row_res_hall = $result_res_hall->fetch_assoc();

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

    //Get Out-sourcced Services
    $sql_out = "SELECT service_id FROM `service` WHERE service_type='outsource'";
    $result_out = $db->query($sql_out);
    $services_out = array();
    while ($row_out = $result_out->fetch_assoc()) {
        $services_out[] = $row_out['service_id'];
    }
    ?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <div class="card bg-light" style="font-size:13px;">
                <div class="card-header">
                    <h3>Assigned Suppliers</h3>
                </div>
                <div class="card-body">
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
                        <h5>Assigned Suppliers</h5>
                    </div>
                    <div class="row">
                        <?php
                        if (!empty($services_package) || !empty($services_addon)) {
                            ?>
                            <?php
                            if (in_array('2', $services_package) || in_array('2', $services_addon)) {
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
                                                    . "AND service_id='2' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('3', $services_package) || in_array('3', $services_addon)) {
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
                                                    . "AND service_id='3' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('4', $services_package) || in_array('4', $services_addon)) {
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
                                                    . "AND service_id='4' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('5', $services_package) || in_array('5', $services_addon)) {
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
                                                    . "AND service_id='5' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
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
                                            <label class="form-label" for="fresh_flo_supplier">Fresh Flowers</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql_supplier = "SELECT company_name FROM supplier "
                                                    . "WHERE supplier_id IN "
                                                    . "(SELECT supplier_id FROM arr_assign_supplier "
                                                    . "WHERE arr_plan_id = '$arr_plan_id' "
                                                    . "AND service_id='8' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
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
                                            <label class="form-label" for="poruwa_supplier">Poruwa</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql_supplier = "SELECT company_name FROM supplier "
                                                    . "WHERE supplier_id IN "
                                                    . "(SELECT supplier_id FROM arr_assign_supplier "
                                                    . "WHERE arr_plan_id = '$arr_plan_id' "
                                                    . "AND service_id='9' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('10', $services_package) || in_array('10', $services_addon)) {
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
                                                    . "AND service_id='10' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('11', $services_package) || in_array('11', $services_addon)) {
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
                                                    . "AND service_id='11' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('12', $services_package) || in_array('12', $services_addon)) {
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
                                                    . "AND service_id='12' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('13', $services_package) || in_array('13', $services_addon)) {
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
                                                    . "AND service_id='13' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
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
                                            <label class="form-label" for="wed_cake_supplier">Wedding Cake Structure</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql_supplier = "SELECT company_name FROM supplier "
                                                    . "WHERE supplier_id IN "
                                                    . "(SELECT supplier_id FROM arr_assign_supplier "
                                                    . "WHERE arr_plan_id = '$arr_plan_id' "
                                                    . "AND service_id='14' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('15', $services_package) || in_array('15', $services_addon)) {
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
                                                    . "AND service_id='15' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('17', $services_package) || in_array('17', $services_addon)) {
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
                                                    . "AND service_id='17' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('18', $services_package) || in_array('18', $services_addon)) {
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
                                                    . "AND service_id='18' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
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
                                            <label class="form-label" for="wed_photo_supplier">Wedding Photographer</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql_supplier = "SELECT company_name FROM supplier "
                                                    . "WHERE supplier_id IN "
                                                    . "(SELECT supplier_id FROM arr_assign_supplier "
                                                    . "WHERE arr_plan_id = '$arr_plan_id' "
                                                    . "AND service_id='23' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('25', $services_package) || in_array('25', $services_addon)) {
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
                                                    . "AND service_id='25' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('26', $services_package) || in_array('26', $services_addon)) {
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
                                                    . "AND service_id='26' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
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
                                            <label class="form-label" for="a_flora_supplier">Artificial Flower Decorations</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql_supplier = "SELECT company_name FROM supplier "
                                                    . "WHERE supplier_id IN "
                                                    . "(SELECT supplier_id FROM arr_assign_supplier "
                                                    . "WHERE arr_plan_id = '$arr_plan_id' "
                                                    . "AND service_id='27' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
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
                                            <label class="form-label" for="birth_cake_supplier">Birthday Cake Structure</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql_supplier = "SELECT company_name FROM supplier "
                                                    . "WHERE supplier_id IN "
                                                    . "(SELECT supplier_id FROM arr_assign_supplier "
                                                    . "WHERE arr_plan_id = '$arr_plan_id' "
                                                    . "AND service_id='28' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('29', $services_package) || in_array('29', $services_addon)) {
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
                                                    . "AND service_id='29' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
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
                                            <label class="form-label" for="birth_photo_supplier">Birthday Photographer</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql_supplier = "SELECT company_name FROM supplier "
                                                    . "WHERE supplier_id IN "
                                                    . "(SELECT supplier_id FROM arr_assign_supplier "
                                                    . "WHERE arr_plan_id = '$arr_plan_id' "
                                                    . "AND service_id='30' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
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
                                            <label class="form-label" for="home_cake_supplier">Homecoming Cake Structure</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql_supplier = "SELECT company_name FROM supplier "
                                                    . "WHERE supplier_id IN "
                                                    . "(SELECT supplier_id FROM arr_assign_supplier "
                                                    . "WHERE arr_plan_id = '$arr_plan_id' "
                                                    . "AND service_id='31' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if (in_array('33', $services_package) || in_array('33', $services_addon)) {
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
                                                    . "AND service_id='33' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
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
                                            <label class="form-label" for="ballon_deco_supplier">Balloon Decoration</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql_supplier = "SELECT company_name FROM supplier "
                                                    . "WHERE supplier_id IN "
                                                    . "(SELECT supplier_id FROM arr_assign_supplier "
                                                    . "WHERE arr_plan_id = '$arr_plan_id' "
                                                    . "AND service_id='32' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
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
                                            <label class="form-label" for="eng_photo_supplier">Engagement Photographer</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql_supplier = "SELECT company_name FROM supplier "
                                                    . "WHERE supplier_id IN "
                                                    . "(SELECT supplier_id FROM arr_assign_supplier "
                                                    . "WHERE arr_plan_id = '$arr_plan_id' "
                                                    . "AND service_id='34' AND (assign_status_id = '1' OR assign_status_id = '2'))";
                                            $result_supplier = $db->query($sql_supplier);
                                            $row_supplier = $result_supplier->fetch_assoc();
                                            ?>
                                            <p><strong><i><?= $row_supplier['company_name'] ?></i></strong></p>
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
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</main>

<?php include '../footer.php'; ?>
