<?php
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main">
    <section>
        <div class="pagetitle">
            <h1>Reservation</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>reservation/reservation.php">Reservation</a></li>
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>reservation/reservation_history.php">Reservation History</a></li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    extract($_GET);
                    $db = dbConn();
                    $sql = "SELECT * FROM reservation WHERE reservation_id = $reservation_id";
                    $result = $db->query($sql);
                    $row = $result->fetch_assoc();
                }
                ?>
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mt-3 mb-3" style="text-align:center;">
                                <h4>Reservation Details</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5 mt-3 mb-3" style="text-align:center;">
                                <div class="table-responsive">
                                    <table class="table table-striped table-light table-bordered" style="font-size:13px;">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Reservation Details</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align:left;">
                                            <tr>
                                                <td>Reservation No</td>
                                                <td><?= $row['reservation_no'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Event</td>
                                                <?php
                                                $sql_event = "SELECT event_name FROM event WHERE event_id=" . $row['event_id'];
                                                $result_event = $db->query($sql_event);
                                                $row_event = $result_event->fetch_assoc();
                                                ?>
                                                <td><?= $row_event['event_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Event Date</td>
                                                <td><?= $row['event_date'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Function Mode</td>
                                                <td><?= $row['function_mode'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Time</td>
                                                <td><?= $row['start_time'] . '-' . $row['end_time'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Guest Count</td>
                                                <td><?= $row['guest_count'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Hall</td>
                                                <?php
                                                $sql_hall = "SELECT hall_name FROM hall WHERE hall_id=" . $row['hall_id'];
                                                $result_hall = $db->query($sql_hall);
                                                $row_hall = $result_hall->fetch_assoc();
                                                ?>
                                                <td><?= $row_hall['hall_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Selected Package</td>
                                                <?php
                                                $sql_package = "SELECT package_name FROM package WHERE package_id=" . $row['package_id'];
                                                $result_package = $db->query($sql_package);
                                                $row_package = $result_package->fetch_assoc();
                                                $per_person_price = number_format($row['per_person_price'], '2', '.', ',');
                                                ?>
                                                <td><?= $row_package['package_name'] . '( Rs.' . $per_person_price . ')' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Reservation Status</td>
                                                <?php
                                                $sql_res_status = "SELECT reservation_status FROM reservation_status WHERE reservation_status_id=" . $row['reservation_status_id'];
                                                $result_res_status = $db->query($sql_res_status);
                                                $row_res_status = $result_res_status->fetch_assoc();
                                                ?>
                                                <td><?= $row_res_status['reservation_status'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-5 mt-3 mb-3" style="text-align:center;">
                                <div class="table-responsive">
                                    <table class="table table-striped table-light table-bordered" style="font-size:13px;">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Invoice Details</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align:left;">
                                            <tr>
                                                <td>Total Package Price (Rs.)</td>
                                                <?php
                                                $total_package_price = number_format($row['total_package_price'], '2', '.', ',');
                                                ?>
                                                <td><?= $total_package_price ?></td>
                                            </tr>
                                            <?php
                                            $sql_addon_items = "SELECT * FROM reservation_addon_items WHERE reservation_id='$reservation_id'";
                                            $result_addon_items = $db->query($sql_addon_items);
                                            if ($result_addon_items->num_rows > 0) {
                                                ?>
                                                <tr>
                                                    <td>Price of Add-on Items (Rs.)</td>
                                                    <?php
                                                    $addon_price = number_format($row['addon_item_price'], '2', '.', ',');
                                                    ?>
                                                    <td><?= $addon_price ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            $sql_addon_services = "SELECT * FROM reservation_addon_service WHERE reservation_id='$reservation_id'";
                                            $result_addon_services = $db->query($sql_addon_services);
                                            if ($result_addon_services->num_rows > 0) {
                                                ?>
                                                <tr>
                                                    <td>Price of Add-on Services (Rs.)</td>
                                                    <?php
                                                    $service_price = number_format($row['addon_service_price'], '2', '.', ',');
                                                    ?>
                                                    <td><?= $service_price ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr>
                                                <td>Total Amount for the Reservation (Rs.)</td>
                                                <?php
                                                $total_price = number_format($row['total_amount'], '2', '.', ',');
                                                ?>
                                                <td><?= $total_price ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tax (%)</td>
                                                <?php
                                                $tax = number_format($row['tax_rate'], '2');
                                                ?>
                                                <td><?= $tax ?></td>
                                            </tr>
                                            <tr>
                                                <td>Price After Tax (Rs.)</td>
                                                <?php
                                                $taxed_price = number_format($row['taxed_price'], '2', '.', ',');
                                                ?>
                                                <td><?= $taxed_price ?></td>
                                            </tr>
                                            <tr>
                                                <td>Discount (%)</td>
                                                <?php
                                                $discount = number_format($row['discount_rate'], '2');
                                                ?>
                                                <td><?= $discount ?></td>
                                            </tr>
                                            <tr>
                                                <td>Discounted Price (Rs.)</td>
                                                <?php
                                                $discounted_price = number_format($row['discounted_price'], '2', '.', ',');
                                                ?>
                                                <td><?= $discounted_price ?></td>
                                            </tr>
                                            <tr>
                                                <td>Reservation Payment Status</td>
                                                <?php
                                                $sql_res_status = "SELECT payment_status FROM reservation_payment_status WHERE payment_status_id=" . $row['reservation_payment_status_id'];
                                                $result_res_status = $db->query($sql_res_status);
                                                $row_res_status = $result_res_status->fetch_assoc();
                                                ?>
                                                <td><?= $row_res_status['payment_status'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <?php
                            $sql_addon_items = "SELECT * FROM reservation_addon_items WHERE reservation_id='$reservation_id'";
                            //print_r($sql_addon_items);
                            $result_addon_items = $db->query($sql_addon_items);
                            if ($result_addon_items->num_rows > 0) {
                                ?>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-light table-bordered" style="font-size:13px;">
                                            <thead style="text-align:center;">
                                                <tr>
                                                    <th colspan="2">Selected Add-on Items</th>
                                                </tr>
                                                <tr>
                                                    <th>Item Name</th>
                                                    <th>Portion Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody style="text-align:left;">
                                                <?php
                                                while ($row_addon_items = $result_addon_items->fetch_assoc()) {
                                                    //var_dump($row_addon_items);
                                                    $sql_addon_item_list = "SELECT i.item_name,ai.portion_qty FROM menu_item i LEFT JOIN reservation_addon_items ai ON ai.item_id=i.item_id WHERE ai.item_id=" . $row_addon_items['item_id'] . " AND ai.reservation_id = '$reservation_id'";
                                                    //print_r($sql_addon_item_list);
                                                    $result_addon_item_list = $db->query($sql_addon_item_list);
                                                    $row_addon_item_list = $result_addon_item_list->fetch_assoc();
                                                    ?>
                                                    <tr>
                                                        <td><?= $row_addon_item_list['item_name'] ?></td>
                                                        <td><?= $row_addon_item_list['portion_qty'] ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            $sql_addon_services = "SELECT * FROM reservation_addon_service WHERE reservation_id='$reservation_id'";
                            //print_r($sql_addon_items);
                            $result_addon_services = $db->query($sql_addon_services);
                            if ($result_addon_services->num_rows > 0) {
                                ?>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-light table-bordered" style="font-size:13px;">
                                            <thead style="text-align:center;">
                                                <tr>
                                                    <th colspan="2">Selected Add-on Services</th>
                                                </tr>
                                                <tr>
                                                    <th>Service</th>
                                                </tr>
                                            </thead>
                                            <tbody style="text-align:left;">
                                                <?php
                                                while ($row_addon_services = $result_addon_services->fetch_assoc()) {
                                                    //var_dump($row_addon_services);
                                                    $sql_addon_services_list = "SELECT s.service_name FROM service s LEFT JOIN reservation_addon_service sa ON sa.service_id=s.service_id WHERE sa.service_id=" . $row_addon_services['service_id'] . " AND sa.reservation_id = '$reservation_id'";
                                                    //print_r($sql_addon_services_list);
                                                    $result_addon_services_list = $db->query($sql_addon_services_list);
                                                    $row_addon_services_list = $result_addon_services_list->fetch_assoc();
                                                    ?>
                                                    <tr>
                                                        <td><?= $row_addon_services_list['service_name'] ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php
include '../customer/footer.php';
?>