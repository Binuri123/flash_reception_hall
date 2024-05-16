<?php
ob_start();
include '../customer/header.php';
include'../customer/sidebar.php';
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Reservation</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Event Details</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <?php
    extract($_GET);
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET)) {
        $db = dbConn();
        $sql = "SELECT * FROM check_availability WHERE check_availability_id='$check_availability_id'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        //Assign values stored in the check availability table in the database when preveiously checking the availability 
        $event = $row['event_id'];
        $function_mode = $row['function_mode_id'];
        $event_date = $row['event_date'];
//        $start_time = $_SESSION['reservation_details']['event_details']['start_time'];
//        $end_time = $_SESSION['reservation_details']['event_details']['end_time'];
        $guest_count = $row['guest_count'];
        $hall = $row['hall_id'];
    }

//Check Request Method when moving backward
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_SESSION['reservation_details']['event_details'])) {
        $event = $_SESSION['reservation_details']['event_details']['event'];
        $event_date = $_SESSION['reservation_details']['event_details']['event_date'];
        $function_mode = $_SESSION['reservation_details']['event_details']['function_mode'];
        $start_time = $_SESSION['reservation_details']['event_details']['start_time'];
        $end_time = $_SESSION['reservation_details']['event_details']['end_time'];
        $guest_count = $_SESSION['reservation_details']['event_details']['guest_count'];
        $hall = $_SESSION['reservation_details']['event_details']['hall'];
    }

    extract($_POST);
    //var_dump($_POST);
//Checking request method when moving forward
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'event_details') {

        $guest_count = cleanInput($guest_count);

        $message = array();
        //Required Field Checking

        if (empty($guest_count)) {
            $message['error_guest_count'] = "Guest Count Should be Selected...";
        }

        $db = dbConn();
        $sql = "SELECT customer_no FROM customer WHERE customer_id=" . $_SESSION['customer_id'];
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $customer_no = $row['customer_no'];
        if (empty($message)) {
            $_SESSION['reservation_details']['event_details'] = array('customer_no' => @$customer_no, 'event' => @$event, 'event_date' => @$event_date, 'function_mode' => @$function_mode, 'start_time' => @$start_time, 'end_time' => @$end_time, 'guest_count' => @$guest_count, 'hall' => @$hall);
            //var_dump($_SESSION['reservation_details']);
            $sql = "DELETE FROM check_availability WHERE check_availability_id='$check_availability_id'";
            $db->query($sql);
            header('Location:package.php');
        }
    }
    ?>
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card bg-light">
                    <div class="card-header bg-light">
                        <ul class="nav nav-tabs card-header-tabs nav-justified" style="font-size:14px;">
                            <li class="nav-item"><a class="nav-link active" href="?tab=event_details">Event Details</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=package">Package</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=add_ons">Add-ons</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=service">Service</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=invoice">Invoice</a></li>
                        </ul>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mt-3 mb-3">
                                    <div class="card-body" style="font-size:13px;">
                                        <div class="tab-container active">
                                            <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                                <div class="row">
                                                    <div class="col-md-12 mt-3">
                                                        <p style="margin:0;color:lightseagreen;"><strong><i>Here are the event details you've checked previously at the availability check. You can make changes to your expected guest count if needed.</i></strong></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-2 mt-2">
                                                                <label class="form-label" for="event"><strong><i>Event</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-2 mt-2"><strong>:</strong></div>
                                                            <div class="col-md-7 mb-2 mt-2">
                                                                <?php
                                                                if (!empty(@$event)) {
                                                                    $db = dbConn();
                                                                    $sql = "SELECT event_name FROM event WHERE event_id='$event'";
                                                                    $result = $db->query($sql);
                                                                    $row = $result->fetch_assoc();
                                                                }
                                                                ?>
                                                                <div style="font-size:13px;"><?= $row['event_name'] ?></div>
                                                                <input type="hidden" name="event" value="<?= @$event ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-2 mt-2">
                                                                <label class="form-label" for="event_date"><strong><i>Date</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-2 mt-2"><strong>:</strong></div>
                                                            <div class="col-md-7 mb-2 mt-2">
                                                                <div style="font-size:13px;"><?= @$event_date ?></div>
                                                                <input type="hidden" name="event_date" value="<?= @$event_date ?>">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-2">
                                                                <label class="form-label" for="start_time"><strong><i>Start Time</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-2"><strong>:</strong></div>
                                                            <div class="col-md-7 mb-2">
                                                                <?php
                                                                $db = dbConn();
                                                                $sql = "SELECT start_time FROM event_function_mode WHERE event_function_mode_id ='$function_mode'";
                                                                $result = $db->query($sql);
                                                                $row = $result->fetch_assoc();
                                                                ?>
                                                                <div style="font-size:13px;"><?= $row['start_time'] ?></div>
                                                                <input type="hidden" name="start_time" value="<?= $row['start_time'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-2">
                                                                <label class="form-label" for="end_time"><strong><i>End Time</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-2"><strong>:</strong></div>
                                                            <div class="col-md-7 mb-2">
                                                                <?php
                                                                $db = dbConn();
                                                                $sql = "SELECT end_time FROM event_function_mode WHERE event_function_mode_id ='$function_mode'";
                                                                $result = $db->query($sql);
                                                                $row = $result->fetch_assoc();
                                                                ?>
                                                                <div style="font-size:13px;"><?= $row['end_time'] ?></div>
                                                                <input type="hidden" name="end_time" value="<?= $row['end_time'] ?>">
                                                                <input type="hidden" name="function_mode" value="<?= @$function_mode ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-2">
                                                                <label class="form-label" for="hall"><strong><i>Hall</i></strong></label>
                                                            </div>
                                                            <div class="col-md-1 mb-2"><strong>:</strong></div>
                                                            <div class="col-md-7 mb-2">
                                                                <?php
                                                                $db = dbConn();
                                                                $sql = "SELECT hall_no,hall_name FROM hall WHERE hall_id='$hall'";
                                                                $result = $db->query($sql);
                                                                $row = $result->fetch_assoc();
                                                                ?>
                                                                <div style="font-size:13px;"><?= $row['hall_name'] ?></div>
                                                                <input type="hidden" name="hall" value="<?= @$hall ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-5 mb-2">
                                                                <label class="form-label" for="guest_count" style="font-size:13px;"><strong><i>Guest Count</i></strong></label>
                                                            </div>
                                                            <div class="col-md-5 mb-2">
                                                                <?php
                                                                if (!empty(@$hall)) {
                                                                    $db = dbConn();
                                                                    $sql = "SELECT min_capacity,max_capacity FROM hall WHERE hall_id='$hall'";
                                                                    $result = $db->query($sql);
                                                                    $row = $result->fetch_assoc();
                                                                    $min_count = $row['min_capacity'];
                                                                    $max_count = $row['max_capacity'];
                                                                }
                                                                ?>
                                                                <input class="form-control" type="number" min="<?= $min_count ?>" max="<?= $max_count ?>" name="guest_count" id="guest_count" value="<?= @$guest_count ?>" style="font-size:13px;">
                                                                <div class="text-danger"><?= @$message["error_guest_count"] ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6"></div>
                                                    <div class="col-md-6" style="text-align: right">
                                                        <input type="hidden" name="check_availability_id" value="<?=@$check_availability_id?>">
                                                        <button type="submit" name="action" value="event_details" class="btn btn-success btn-sm" style="width:100px;">Next<i class="bi bi-arrow-right"></i></button>
                                                    </div>
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
            <div class="col-md-2"></div>
        </div>
    </section>
</main>
<?php 
include '../customer/footer.php';
ob_end_flush();
?>