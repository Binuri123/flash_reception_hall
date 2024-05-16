<?php
ob_start();
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Reservation</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Reservation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_SESSION['services'])) {
        $services = array();
        foreach ($_SESSION['services'] as $unit) {
            $service_id = $unit['service_id'];
            $services[] = $service_id;
        }
        if (!empty($_SESSION['services'])) {
            @$additional_service_price = $_SESSION['reservation_details']['service_price'];
        }
    }

    extract($_POST);
    if (isset($services)) {
        @$additional_service_price = 0;
        foreach ($services as $unit) {
            $db = dbConn();
            $sql = "SELECT s.service_id,s.final_price FROM service s WHERE s.service_id='$unit'";
            //print_r($sql);
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            //var_dump($row);
            if (in_array($unit,$services)) {
                $price = $row['final_price'];
                $additional_service_price += $price;
                //var_dump($additional_service_price);
            }
            $_SESSION['services'][$row['service_id']] = array('service_id' => $row['service_id'],'service_price' => $row['final_price']);

            //var_dump($_SESSION['services']);
        }
        //var_dump($additional_service_price);
        $_SESSION['reservation_details']['service_price'] = $additional_service_price;
    }

    if (!empty($services) && !empty($_SESSION['services'])) {
        foreach ($_SESSION['services'] as $value) {
            $service_id = $value['service_id'];
            if (!in_array($service_id, $services)) {
                unset($_SESSION['services'][$service_id]);
                //print_r($_SESSION['services']);
            }
        }
    } elseif (empty($services)) {
        unset($_SESSION['services']);
    }

    //var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'addon_services') {

        header('Location:invoice.php');
    }
    ?>
    <section class="section dashboard">
        <?php
        //var_dump(@$_SESSION['services']);
        //var_dump(@$_SESSION['reservation_details']['service_price']);
        //echo @$service_price;
        ?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card bg-light">
                    <div class="card-header bg-light">
                        <ul class="nav nav-tabs card-header-tabs nav-justified" style="font-size:14px;">
                            <li class="nav-item"><a class="nav-link" href="?tab=event_details">Event Details</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=package">Package</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=add_ons">Add-ons</a></li>
                            <li class="nav-item"><a class="nav-link active" href="?tab=service">Service</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=invoice">Invoice</a></li>
                        </ul>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mt-3 mb-3">
                                    <div class="card-body" style="font-size:14px;">
                                        <div class="tab-container active">
                                            <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                                <div class="row">
                                                    <div class="col-md-6 mt-3">
                                                        <a href="<?= WEB_PATH ?>reservation/add_on.php" class="btn btn-success btn-sm" style="width:100px;font-size:13px;"><i class="bi bi-arrow-left"></i> Back</a>
                                                    </div>
                                                    <div class="col-md-6 mt-3" style="text-align:right">
                                                        <button type="submit" name="action" value="addon_services" class="btn btn-success btn-sm" style="width:100px;font-size:13px;">Next <i class="bi bi-arrow-right"></i></button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mt-3">
                                                        <p style="margin:0;color:lightseagreen;"><strong><i>You can request other services apart from the services included in the selected package.</i></strong></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="total_service_price"><strong><i>Total Service Price (Rs.)</i></strong></label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <?php
                                                                if (!empty($_SESSION['services'])) {
                                                                    $service_price = $_SESSION['reservation_details']['service_price'];
                                                                } else {
                                                                    $service_price = 0;
                                                                }
                                                                $service_price = number_format($service_price, '2', '.', ',');
                                                                ?>
                                                                <div><?= @$service_price ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-8">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead style="font-size:13px;">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Service Name</th>
                                                                        <th scope="col">Price (Rs.)</th>
                                                                        <th scope="col"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody style="font-size:13px;">
                                                                    <?php
                                                                    $package_id = $_SESSION['reservation_details']['package_details']['package_id'];
                                                                    $event_id = $_SESSION['reservation_details']['event_details']['event'];
                                                                    $db = dbConn();
                                                                    $sql = "SELECT c.category_id,s.service_id,s.service_name,s.final_price FROM service s "
                                                                            . "LEFT JOIN service_category c ON c.category_id=s.category_id "
                                                                            . "WHERE s.availability = 'Available' AND s.addon_status = 'Yes' "
                                                                            . "AND service_id NOT IN (SELECT service_id FROM package_services WHERE package_id = '$package_id') "
                                                                            . "AND service_id IN (SELECT service_id FROM event_service WHERE event_id = '$event_id') ORDER BY c.category_id ASC";
                                                                    //print_r($sql);
                                                                    $result = $db->query($sql);
                                                                    $i = 1;
                                                                    while ($row = $result->fetch_assoc()) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $i ?></td>
                                                                            <td><?= $row['service_name'] ?></td>
                                                                            <td><?= $row['final_price'] ?></td>
                                                                            <td style="width:50px">
                                                                                <input class="form-check-input" onchange="form.submit()" type="checkbox" id="<?= $row['service_id'] ?>" name="services[]" value="<?= $row['service_id'] ?>" <?php if (isset($services) && in_array($row['service_id'], $services)) { ?>checked <?php } ?>>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        $i++;
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td style="text-align:right"><strong>Total (Rs.)</strong></td>
                                                                        <td colspan="2"><?= @$service_price ?></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2"></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php include('../customer/footer.php') ?>
<?php ob_end_flush() ?>