<?php
ob_start();
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
    </div>
    <?php
    extract($_POST);
    //var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'make_reservation') {
        //echo 'inside';
        $customer_no = $_SESSION['reservation_details']['event_details']['customer_no'];
        $event_id = $_SESSION['reservation_details']['event_details']['event'];
        $event_date = $_SESSION['reservation_details']['event_details']['event_date'];
        $function_mode = $_SESSION['reservation_details']['event_details']['function_mode'];
        $start_time = $_SESSION['reservation_details']['event_details']['start_time'];
        $end_time = $_SESSION['reservation_details']['event_details']['end_time'];
        $guest_count = $_SESSION['reservation_details']['event_details']['guest_count'];
        $hall = $_SESSION['reservation_details']['event_details']['hall'];
        $package_id = $_SESSION['reservation_details']['package_details']['package_id'];
        $per_person_price = $_SESSION['reservation_details']['package_details']['per_person_price'];
        $total_package_price = $_SESSION['reservation_details']['package_details']['total_package_price'];

        if (!empty($_SESSION['reservation_details']['additional_price'])) {
            $addon_price = $_SESSION['reservation_details']['additional_price'];
        } else {
            $addon_price = 0;
        }

        if (!empty($_SESSION['reservation_details']['service_price'])) {
            $service_price = $_SESSION['reservation_details']['service_price'];
        } else {
            $service_price = 0;
        }

        $total_package_price = str_replace(',', '', $total_package_price);
        $addon_price = str_replace(',', '', $addon_price);
        $service_price = str_replace(',', '', $service_price);
        $taxed_price = str_replace(',', '', $taxed_price);
        $discounted_price = str_replace(',', '', $discounted_price);
        $total_reservation_amount = str_replace(',', '', $total_reservation_amount);

        $db = dbConn();
        $sql = "SELECT function_mode FROM function_mode WHERE function_mode_id ="
                . "(SELECT function_mode_id FROM event_function_mode WHERE event_function_mode_id = '$function_mode')";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $function_mode_name = $row['function_mode'];
        date_default_timezone_set('Asia/Colombo');
        $cDate = date('Y-m-d');
        $cTime = date('H:i');

        $sql = "INSERT INTO reservation(customer_no, event_id, event_date, function_mode, start_time, end_time, "
                . "guest_count, hall_id, package_id, per_person_price, total_package_price, addon_item_price, "
                . "addon_service_price, total_amount, tax_rate, taxed_price, discount_rate, discounted_price, "
                . "reservation_payment_status_id, remarks, reservation_status_id, add_date,add_time) "
                . "VALUES('$customer_no', '$event_id', '$event_date', '$function_mode_name', '$start_time', '$end_time', "
                . "'$guest_count', '$hall', '$package_id', '$per_person_price', '$total_package_price', '$addon_price', "
                . "'$service_price', '$total_reservation_amount', '$tax', '$taxed_price', '$discount', '$discounted_price', "
                . "'1', '$remarks', '1', '$cDate','$cTime')";
        print_r($sql);
        $db->query($sql);

        $reservation_id = $db->insert_id;
        $reservation_no = "R" . date('Y') . date('m') . date('d') . $reservation_id;

        $sql = "UPDATE reservation SET reservation_no='$reservation_no' WHERE reservation_id='$reservation_id'";
        $db->query($sql);

        if (!empty($_SESSION['additional_items'])) {
            foreach ($_SESSION['additional_items'] as $value) {
                $item_id = $value['item_id'];
                $portion_qty = $value['portion_qty'];
                $portion_price = $value['portion_price'];
                $total_portion_price = $value['total_portion_price'];
                $sql = "INSERT INTO reservation_addon_items(reservation_id, item_id, portion_price, portion_qty, total_portion_price) "
                        . "VALUES('$reservation_id','$item_id',$portion_price,$portion_qty,$total_portion_price)";
                $db->query($sql);
            }
        }

        if (!empty($_SESSION['services'])) {
            foreach ($_SESSION['services'] as $value) {
                $service_id = $value['service_id'];
                $service_price = $value['service_price'];
                $sql = "INSERT INTO reservation_addon_service(reservation_id,service_id,service_price) "
                        . "VALUES('$reservation_id','$service_id',$service_price)";
                $db->query($sql);
            }
        }
        
        $sql_cust = "SELECT t.title_name,c.first_name,c.last_name,c.email FROM customer c "
                        . "LEFT JOIN customer_titles t ON c.title_id=t.title_id "
                        . "WHERE c.customer_no='".$customer_no."'";
        $result_cust = $db->query($sql_cust);
        $row_cust = $result_cust->fetch_assoc();
        $to = $row_cust['email'];
        $recepient_name = $row_cust['title_name'].". ".$row_cust['first_name']." ".$row_cust['last_name'];
        $subject = 'Flash Reception Hall - Reservation Placement';
        $body = "<p>Thank you for choosing Flash Reception Hall for your special day. You have placed a Reservation as follows.</p>";
        $body .= "<br>";
        $sql_event = "SELECT event_name FROM event WHERE event_id=$event_id";
        print_r($sql_event);
        $res_event = $db->query($sql_event);
        $row_event = $res_event->fetch_assoc();
        $body .= "<p>Event : ".$row_event['event_name']."</p>";
        $body .= "<p>Date of the Event : ".$event_date."</p>";
        $body .= "<p>From:".$start_time." To:".$end_time."</p>";
        $sql_hall = "SELECT hall_name FROM hall WHERE hall_id=$hall";
        $res_hall = $db->query($sql_hall);
        $row_hall = $res_hall->fetch_assoc();
        $body .= "<p>Reserved Hall : ".$row_hall['hall_name']."</p>";
        $body .= "<br>";
        $body .= "Please make sure to pay the security fee for the confirmation of your reservation within next 14days.";
        $body .= "If you have any questions or require further details, feel free to reach out to us. We are here to assist you in any way we can to ensure the success of the event.";
        $body .= "<br><br>";
        $body .= "<p>Thank You,</p><br>";
        $body .= "<p>Best Regards,</p><br>";
        $body .= "<p>Flash Reception Hall.</p>";
        $alt_body = "<p>Reservation Placement</p>";
            
        send_email($to, $recepient_name, $subject, $body, $alt_body);
        
        unset($_SESSION['reservation_details']);
        unset($_SESSION['additional_items']);
        unset($_SESSION['services']);
        header('location:reservation_add_success.php?reservation_id=' . $reservation_id);
    }
    ?>
    <section class="section dashboard">
        <?php
        //var_dump($_SESSION['reservation_details']);
        //var_dump($_SESSION['additional_items']);
        //var_dump($_SESSION['services']);
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
                            <li class="nav-item"><a class="nav-link" href="?tab=service">Service</a></li>
                            <li class="nav-item"><a class="nav-link active" href="?tab=invoice">Invoice</a></li>
                        </ul>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="card mt-3 mb-3">
                                    <div class="card-body" style="font-size:13px;">
                                        <div class="tab-container active">
                                            <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                                <div class="row">
                                                    <div class="col-md-12 mt-3">
                                                        <p style="margin:0;color:lightseagreen;"><strong><i>Here is the summary of your total reservation payment.</i></strong></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3 mt-3">
                                                                <label class="form-label" for="total_package_price"><strong><i>Total Package Price (Rs.)</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-3 mt-3"><strong>:</strong></div>
                                                            <div class="col-md-5 mb-3 mt-3">
                                                                <?php
                                                                $total_package_price = $_SESSION['reservation_details']['package_details']['total_package_price'];
                                                                $total_package_price = number_format($total_package_price, '2', '.', ',');
                                                                ?>
                                                                <div><?= $total_package_price ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3 mt-3">
                                                                <label class="form-label" for="addon_price"><strong><i>Price of Add-on Items (Rs.)</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-3 mt-3"><strong>:</strong></div>
                                                            <div class="col-md-5 mb-3 mt-3">
                                                                <?php
                                                                if (!empty($_SESSION['reservation_details']['additional_price'])) {
                                                                    $addon_price = $_SESSION['reservation_details']['additional_price'];
                                                                } else {
                                                                    $addon_price = 0;
                                                                }
                                                                $addon_price = number_format($addon_price, '2', '.', ',');
                                                                ?>
                                                                <div><?= @$addon_price ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" for="service_price"><strong><i>Price of Add-on Services (Rs.)</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-3"><strong>:</strong></div>
                                                            <div class="col-md-5 mb-3">
                                                                <?php
                                                                if (!empty($_SESSION['reservation_details']['service_price'])) {
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
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" for="total_reservation_amount"><strong><i>Total Reservation Amount (Rs.)</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-3"><strong>:</strong></div>
                                                            <div class="col-md-5 mb-3">
                                                                <?php
                                                                if (!empty($_SESSION['reservation_details']['additional_price']) && !empty($_SESSION['reservation_details']['service_price'])) {
                                                                    $total_reservation_amount = str_replace(',', '', $total_package_price) + str_replace(',', '', $addon_price) + str_replace(',', '', $service_price);
                                                                } elseif (empty($_SESSION['reservation_details']['additional_price']) && !empty($_SESSION['reservation_details']['service_price'])) {
                                                                    $total_reservation_amount = str_replace(',', '', $total_package_price) + str_replace(',', '', $service_price);
                                                                } elseif (!empty($_SESSION['reservation_details']['additional_price']) && empty($_SESSION['reservation_details']['service_price'])) {
                                                                    $total_reservation_amount = str_replace(',', '', $total_package_price) + str_replace(',', '', $addon_price);
                                                                } else {
                                                                    $total_reservation_amount = str_replace(',', '', $total_package_price);
                                                                }
                                                                $total_reservation_amount = number_format($total_reservation_amount, '2', '.', ',');
                                                                ?>
                                                                <div><?= @$total_reservation_amount ?></div>
                                                                <input type="hidden" name="total_reservation_amount" value="<?= @$total_reservation_amount ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" for="tax"><strong><i>Tax Rate (%)</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-3"><strong>:</strong></div>
                                                            <div class="col-md-5 mb-3">
                                                                <?php
                                                                $db = dbConn();
                                                                $res_amount = str_replace(',', '', $total_reservation_amount);
                                                                $sql_taxes = "SELECT tax_rate FROM tax WHERE amount<=$res_amount ORDER BY amount DESC LIMIT 1";
                                                                $result_taxes = $db->query($sql_taxes);
                                                                $tax = 0;
                                                                if ($result_taxes->num_rows > 0) {
                                                                    $tax_row = $result_taxes->fetch_assoc();
                                                                    $tax = $tax_row['tax_rate'];
                                                                }
                                                                ?>
                                                                <div><?= number_format($tax, '2') ?></div>
                                                                <input type="hidden" name="tax" value="<?= @$tax ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" for="taxed_price"><strong><i>Price after Tax (Rs.)</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-3"><strong>:</strong></div>
                                                            <div class="col-md-5 mb-3">
                                                                <?php
                                                                $taxed_price = str_replace(',', '', $total_reservation_amount) + str_replace(',', '', $total_reservation_amount) * $tax / 100;
                                                                $taxed_price = number_format($taxed_price, '2', '.', ',');
                                                                ?>
                                                                <div><?= @$taxed_price ?></div>
                                                                <input type="hidden" name="taxed_price" id="taxed_price" value="<?= @$taxed_price ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" for="discount"><strong><i>Discount (%)</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-3"><strong>:</strong></div>
                                                            <div class="col-md-5 mb-3">
                                                                <?php
                                                                $db = dbConn();
                                                                $sql = "SELECT * FROM discount WHERE availability = 'Available'";
                                                                $result = $db->query($sql);
                                                                $row = $result->fetch_assoc();
                                                                $discount = $row['discount_ratio'];
                                                                $discount = number_format($discount, '2');
                                                                ?>
                                                                <div><?= @$discount ?></div>
                                                                <input type="hidden" name="discount" id="discount" value="<?= @$discount ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label" for="discounted_price"><strong><i>Discounted Price (Rs.)</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-3"><strong>:</strong></div>
                                                            <div class="col-md-5 mb-3">
                                                                <?php
                                                                $discounted_price = str_replace(',', '', $taxed_price) - str_replace(',', '', $taxed_price) * $discount;
                                                                $discounted_price = number_format($discounted_price, '2', '.', ',');
                                                                ?>
                                                                <div><?= @$discounted_price ?></div>
                                                                <input type="hidden" name="discounted_price" id="discounted_price" value="<?= @$discounted_price ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label" for="remarks"><strong><i>Remarks [Optional]</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-3"><strong>:</strong></div>
                                                            <div class="col-md-8 mb-3">
                                                                <textarea name="remarks" placeholder="If you have any special request..." class="form-control" id="remarks" value="<?= @$remarks ?>" style="font-size:13px;"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6" style="text-align:left;">
                                                        <a href="<?= WEB_PATH ?>reservation/services.php" class="btn btn-success" style="width:100px;font-size:13px;"><i class="bi bi-arrow-left"></i> Back</a>
                                                    </div>
                                                    <div class="col-md-6" style="text-align:right">
                                                        <button type="submit" name="action" value="make_reservation" class="btn btn-success" style="width:150px;font-size:13px;">Make Reservation</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
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
ob_end_flush();
?>