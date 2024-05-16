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
                <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>arrangement_plan/arrangement_plan.php">Arrangement Plan</a></li>
                <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>arrangement_plan/arrangement_plan.php">Add Request</a></li>
                <li class="breadcrumb-item active">Add Success</li>
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
        <?php ?>
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
                                            <div><?= $row_res['reservation_no'] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-5 mb-3 mt-3">
                                            <label class="form-label" for="reservation_date">Reservation Date</label>
                                        </div>
                                        <div class="col-md-7 mb-3 mt-3">
                                            <div><?= $row_res['event_date'] ?></div>
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
                                        <div class="col-md-5 mb-3">
                                            <label class="form-label" for="event">Selected Package</label>
                                        </div>
                                        <div class="col-md-7 mb-3">
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
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="hall_deco">Hall and Arch Design</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <?php
                                                    $sql_sample_image = "SELECT sample_name,sample_image "
                                                            . "FROM service_samples WHERE service_sample_id="
                                                            . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                            . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='5')";
                                                    $result_sample_image = $db->query($sql_sample_image);
                                                    $row_sample = $result_sample_image->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
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
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="themed_deco">Decoration Theme</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <?php
                                                    $sql_sample_image = "SELECT sample_name,sample_image "
                                                            . "FROM service_samples WHERE service_sample_id="
                                                            . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                            . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='7')";
                                                    $result_sample_image = $db->query($sql_sample_image);
                                                    $row_sample = $result_sample_image->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
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
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="fresh_flora">Fresh Flower Decoration</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <?php
                                                    $sql_sample_image = "SELECT sample_name,sample_image "
                                                            . "FROM service_samples WHERE service_sample_id="
                                                            . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                            . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='8')";
                                                    $result_sample_image = $db->query($sql_sample_image);
                                                    $row_sample = $result_sample_image->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
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
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="poruwa">Poruwa Design</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <?php
                                                    $sql_sample_image = "SELECT sample_name,sample_image "
                                                            . "FROM service_samples WHERE service_sample_id="
                                                            . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                            . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='9')";
                                                    $result_sample_image = $db->query($sql_sample_image);
                                                    $row_sample = $result_sample_image->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
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
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="wed_cake">Cake Structure</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <?php
                                                    $sql_sample_image = "SELECT sample_name,sample_image "
                                                            . "FROM service_samples WHERE service_sample_id="
                                                            . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                            . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='14')";
                                                    $result_sample_image = $db->query($sql_sample_image);
                                                    $row_sample = $result_sample_image->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
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
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="wed_photo">Photography Package</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <?php
                                                    $sql_sample_image = "SELECT sample_name,sample_image "
                                                            . "FROM service_samples WHERE service_sample_id="
                                                            . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                            . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='23')";
                                                    $result_sample_image = $db->query($sql_sample_image);
                                                    $row_sample = $result_sample_image->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
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
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="a_flora">Artificial Flower Decoration</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <?php
                                                    $sql_sample_image = "SELECT sample_name,sample_image "
                                                            . "FROM service_samples WHERE service_sample_id="
                                                            . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                            . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='27')";
                                                    $result_sample_image = $db->query($sql_sample_image);
                                                    $row_sample = $result_sample_image->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
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
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="birth_cake">Cake Structure</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <?php
                                                    $sql_sample_image = "SELECT sample_name,sample_image "
                                                            . "FROM service_samples WHERE service_sample_id="
                                                            . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                            . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='28')";
                                                    $result_sample_image = $db->query($sql_sample_image);
                                                    $row_sample = $result_sample_image->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
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
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="birth_photo">Photography Package</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <?php
                                                    $sql_sample_image = "SELECT sample_name,sample_image "
                                                            . "FROM service_samples WHERE service_sample_id="
                                                            . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                            . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='30')";
                                                    $result_sample_image = $db->query($sql_sample_image);
                                                    $row_sample = $result_sample_image->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
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
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="home_cake">Cake Structure</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <?php
                                                    $sql_sample_image = "SELECT sample_name,sample_image "
                                                            . "FROM service_samples WHERE service_sample_id="
                                                            . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                            . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='31')";
                                                    $result_sample_image = $db->query($sql_sample_image);
                                                    $row_sample = $result_sample_image->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
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
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="ballon_deco">Balloon Decorations</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <?php
                                                    $sql_sample_image = "SELECT sample_name,sample_image "
                                                            . "FROM service_samples WHERE service_sample_id="
                                                            . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                            . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='32')";
                                                    $result_sample_image = $db->query($sql_sample_image);
                                                    $row_sample = $result_sample_image->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
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
                                            <div class="row mt-3">
                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label" for="eng_photo">Photography Package</label>
                                                </div>
                                                <div class="col-md-7 mb-3">
                                                    <?php
                                                    $sql_sample_image = "SELECT sample_name,sample_image "
                                                            . "FROM service_samples WHERE service_sample_id="
                                                            . "(SELECT service_sample_id FROM arrangement_plan_samples "
                                                            . "WHERE arrangement_plan_id='$arr_plan_id' AND service_id='34')";
                                                    $result_sample_image = $db->query($sql_sample_image);
                                                    $row_sample = $result_sample_image->fetch_assoc();
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-12">
                                                            <p><strong><i><?= $row_sample['sample_name'] ?></i></strong></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <img src="../../system/assets/images/service_sample/<?= $row_sample['sample_image'] ?>" style="width:100px;height:100px;">
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
                                <div class="col-md-12" style="text-align:left">
                                    <p><strong><i>Back to <a href="<?=WEB_PATH?>arrangement_plan/arrangement_plan.php" style="color:blue;font-size:13px;">Arrangement Plans</a></i></strong></p>
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