<?php
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Reservation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            extract($_GET);
            $db = dbConn();
            $sql = "SELECT * FROM reservation WHERE reservation_id = $reservation_id";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
        }
        ?>
        <div class="card bg-success-light">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mt-3 mb-3" style="text-align:center;">
                        <h4>Reservation Successfully Added...!!!</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4 mt-3 mb-3" style="text-align:center;">
                        <div class="table-responsive">
                            <table class="table table-striped table-success table-bordered" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th colspan="2">Reservation Details</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align:left;">
                                    <tr>
                                        <td>Reservation No</td>
                                        <td><?=$row['reservation_no']?></td>
                                    </tr>
                                    <tr>
                                        <td>Event</td>
                                        <?php
                                        $sql_event = "SELECT event_name FROM event WHERE event_id=".$row['event_id'];
                                        $result_event = $db->query($sql_event);
                                        $row_event = $result_event->fetch_assoc();
                                        ?>
                                        <td><?=$row_event['event_name']?></td>
                                    </tr>
                                    <tr>
                                        <td>Event Date</td>
                                        <td><?=$row['event_date']?></td>
                                    </tr>
                                    <tr>
                                        <td>Function Mode</td>
                                        <td><?=$row['function_mode']?></td>
                                    </tr>
                                    <tr>
                                        <td>Time</td>
                                        <td><?=$row['start_time'].'-'.$row['end_time']?></td>
                                    </tr>
                                    <tr>
                                        <td>Guest Count</td>
                                        <td><?=$row['guest_count']?></td>
                                    </tr>
                                    <tr>
                                        <td>Hall</td>
                                        <?php
                                        $sql_hall = "SELECT hall_name FROM hall WHERE hall_id=".$row['hall_id'];
                                        $result_hall = $db->query($sql_hall);
                                        $row_hall = $result_hall->fetch_assoc();
                                        ?>
                                        <td><?=$row_hall['hall_name']?></td>
                                    </tr>
                                    <tr>
                                        <td>Selected Package</td>
                                        <?php
                                        $sql_package = "SELECT package_name FROM package WHERE package_id=".$row['package_id'];
                                        $result_package = $db->query($sql_package);
                                        $row_package = $result_package->fetch_assoc();
                                        $per_person_price = number_format($row['per_person_price'],'2','.',',');
                                        ?>
                                        <td><?=$row_package['package_name'].'( Rs.'.$per_person_price.')'?></td>
                                    </tr>
                                    <tr>
                                        <td>Reservation Status</td>
                                        <?php
                                        $sql_res_status = "SELECT reservation_status FROM reservation_status WHERE reservation_status_id=".$row['reservation_status_id'];
                                        $result_res_status = $db->query($sql_res_status);
                                        $row_res_status = $result_res_status->fetch_assoc();
                                        ?>
                                        <td><?=$row_res_status['reservation_status']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-5 mt-3 mb-3" style="text-align:center;">
                        <div class="table-responsive">
                            <table class="table table-striped table-success table-bordered" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th colspan="2">Invoice Details</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align:left;">
                                    <tr>
                                        <td>Total Package Price (Rs.)</td>
                                        <?php
                                        $total_package_price = number_format($row['total_package_price'],'2','.',',');
                                        ?>
                                        <td><?=$total_package_price?></td>
                                    </tr>
                                    <?php
                                    $sql_addon_items = "SELECT * FROM reservation_addon_items WHERE reservation_id='$reservation_id'";
                                    $result_addon_items = $db->query($sql_addon_items);
                                    if($result_addon_items->num_rows >0){
                                        ?>
                                    <tr>
                                        <td>Price of Add-on Items (Rs.)</td>
                                        <?php
                                        $addon_price = number_format($row['addon_item_price'],'2','.',',');
                                        ?>
                                        <td><?=$addon_price?></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    $sql_addon_services = "SELECT * FROM reservation_addon_service WHERE reservation_id='$reservation_id'";
                                    $result_addon_services = $db->query($sql_addon_services);
                                    if($result_addon_services->num_rows >0){
                                        ?>
                                    <tr>
                                        <td>Price of Add-on Services (Rs.)</td>
                                        <?php
                                        $service_price = number_format($row['addon_service_price'],'2','.',',');
                                        ?>
                                        <td><?=$service_price?></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td>Total Amount for the Reservation (Rs.)</td>
                                        <?php
                                        $total_price = number_format($row['total_amount'],'2','.',',');
                                        ?>
                                        <td><?=$total_price?></td>
                                    </tr>
                                    <tr>
                                        <td>Tax (%)</td>
                                        <?php
                                        $tax = number_format($row['tax_rate'],'2');
                                        ?>
                                        <td><?=$tax?></td>
                                    </tr>
                                    <tr>
                                        <td>Price After Tax (Rs.)</td>
                                        <?php
                                        $taxed_price = number_format($row['taxed_price'],'2','.',',');
                                        ?>
                                        <td><?=$taxed_price?></td>
                                    </tr>
                                    <tr>
                                        <td>Discount (%)</td>
                                        <?php
                                        $discount = number_format($row['discount_rate'],'2');
                                        ?>
                                        <td><?=$discount?></td>
                                    </tr>
                                    <tr>
                                        <td>Discounted Price (Rs.)</td>
                                        <?php
                                        $discounted_price = number_format($row['discounted_price'],'2','.',',');
                                        ?>
                                        <td><?=$discounted_price?></td>
                                    </tr>
                                    <tr>
                                        <td>Reservation Payment Status</td>
                                        <?php
                                        $sql_res_status = "SELECT payment_status FROM reservation_payment_status WHERE payment_status_id=".$row['reservation_payment_status_id'];
                                        $result_res_status = $db->query($sql_res_status);
                                        $row_res_status = $result_res_status->fetch_assoc();
                                        ?>
                                        <td><?=$row_res_status['payment_status']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <p><strong><i>Your Reservation Has Successfully Placed. To Confirm the Reservation You Have to Make the Security Fee Payment as soon as Possible.<a href="<?=WEB_PATH?>business_policies/terms_and_conditions.php" style="text-decoration:underline">Terms and Conditions</a></i></strong></p>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i>Make Payment Now?<a href="<?=WEB_PATH?>payment/add.php?reservation_no=<?=$row['reservation_no']?>" style="text-decoration:underline"> Make Payment</a></i></strong></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i>Make Payment Later?<a href="<?=WEB_PATH?>reservation/reservation_history.php" style="text-decoration:underline"> Reservation History</a></i></strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include '../customer/footer.php';
?>