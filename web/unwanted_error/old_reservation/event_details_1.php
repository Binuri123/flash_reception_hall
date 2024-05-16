<?php ob_start() ?>
<?php include '../customer/header.php'; ?>
<?php include('../customer/sidebar.php') ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        extract($_GET);
        @$reservation_no = $_GET['reservation_no'];
        $db = dbConn();
        $sql = "SELECT event_id,date,start_time,end_time,guest_count,hall_id FROM reservation WHERE reservation_no='$reservation_no'";
        $result = $db->query($sql);
        while($row = $result->fetch_assoc()){
            $event = $row['event_id'];
            $reservation_date = $row['date'];
            $start_time = $row['start_time'];
            $end_time = $row['end_time'];
            $guest_count = $row['guest_count'];
            $hall = $row['hall_id'];
        }
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
        extract($_POST);
        //var_dump($_POST);
        $reg_no = $_POST['reg_no'];
        $event = $_POST['event'];
        $reservation_date = $_POST['reservation_date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $guest_count = $_POST['guest_count'];
        $hall = $_POST['hall'];
        
        $_SESSION['reservation_details']['event_details'] =array('reg_no'=>$reg_no,'event'=>$event,'reservation_date'=>$reservation_date,'start_time'=>$start_time,'end_time'=>$end_time,'guest_count'=>$guest_count,'hall'=>$hall);
    
        $message = array();
    
        if(!isset($event)){
            $message['error_event'] = "Event Type Should be Selected...";
        }
        
        if(empty($reservation_date)){
            $message['error_reservation_date'] = "Reservation Date Should be Selected...";
        }
        
        if(empty($start_time)){
            $message['error_start_time'] = "Start Time Should be Selected...";
        }
        
        if(empty($end_time)){
            $message['error_end_time'] = "End Time Should be Selected...";
        }
        
        if(empty($guest_count)){
            $message['error_guest_count'] = "Guest Count Should be Selected...";
        }
        
        if(empty($hall)){
            $message['error_hall'] = "Hall Should be Selected...";
        }
        
        if(empty($message)){
            $db = dbConn();
            $cDate = date('Y-m-d');
            $sql = "INSERT INTO reservation(customer_no,event_id,date,start_time,end_time,guest_count,hall_id,add_date) VALUES('$reg_no','$event','$reservation_date','$start_time','$end_time','$guest_count','$hall','$cDate')";
            //print_r($sql);
            $db->query($sql);
            
            $new_reservation_id = $db->insert_id;
            $reservation_no = date('Y').date('m').date('d').$new_reservation_id;
            $_SESSION['reservation_details']['event_details']['reservation_no'] = $reservation_no;
            
            $sql = "UPDATE reservation SET reservation_no='$reservation_no' WHERE reservation_id=$new_reservation_id";
            $db->query($sql);
            
            header('Location:package.php?reservation_no='.$reservation_no);
        }
    } 
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
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 tabs">
                <ul  class="nav nav-tabs">
                    <li  class="nav-item"><a class="nav-link active" href="?tab=1">Event Details</a></li>
                    <li  class="nav-item"><a class="nav-link" href="?tab=2">Package</a></li>
                    <li  class="nav-item"><a class="nav-link" href="?tab=3">Add-ons</a></li>
                    <li  class="nav-item"><a class="nav-link" href="?tab=4">Invoice</a></li>
                </ul>
                <div class="tab-container active">
                    <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mt-3">
                                        <label class="form-label" for="reg_no">Registration Number</label>
                                    </div>
                                    <div class="col-md-8 mb-3 mt-3">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT reg_no from customers WHERE customer_id=" . $_SESSION['customer_id'];
                                        $result = $db->query($sql);
                                        $row = $result->fetch_assoc();
                                        $reg_no = $row['reg_no'];
                                        ?>
                                        <input class="form-control" readonly type="text" name="reg_no" id="reg_no" value="<?= @$reg_no ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mt-3">
                                        <label class="form-label" for="customer_name">Name</label>
                                    </div>
                                    <div class="col-md-8 mb-3 mt-3">
                                        <?php
                                        $customer_name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];
                                        ?>
                                        <input class="form-control" readonly type="text" name="customer_name" id="customer_name" value="<?= @$customer_name ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="event">Event Type</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <select name="event" id="event" class="form-control">
                                            <option value="">Select an Event</option>
                                            <?php
                                            $db = dbConn();
                                            $sql = "SELECT * FROM event";
                                            $result = $db->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <option value=<?= $row['event_id']; ?> <?php if ($row['event_id'] == @$event) { ?> selected <?php } ?>><?= $row['event_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="text-danger"><?= @$message["error_event"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label" for="reservation_date">Date</label>
                                    </div>
                                    <div class="col-md-8">
                                        <?php
                                        $today = date('Y-m-d');
                                        $min_date = date('Y-m-d', strtotime('+14 days'));
                                        $max_date = date('Y-m-d', strtotime('+1 year'));
                                        ?>
                                        <input class="form-control" type="date" min="<?= $min_date ?>" max="<?= $max_date ?>" name="reservation_date" id="reservation_date" value="<?= @$reservation_date ?>">
                                        <div class="text-danger"><?= @$message["error_reservation_date"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="start_time">Start Time</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <?php
                                        $min_time = date('H:i', strtotime('07:00 AM'));
                                        $max_time = date('H:i', strtotime('00:00 AM'));
                                        ?>
                                        <input class="form-control" type="time" min="<?= $min_time ?>" max="<?= $max_time ?>" name="start_time" id="start_time" value="<?= @$start_time ?>">
                                        <div class="text-danger"><?= @$message["error_start_time"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label" for="end_time">End Time</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" type="time" min="<?= $min_time ?>" max="<?= $max_time ?>" name="end_time" id="end_time" value="<?= @$end_time ?>">
                                        <div class="text-danger"><?= @$message["error_end_time"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label" for="guest_count">Guest Count</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" type="number" min="1" max="1000" name="guest_count" id="guest_count" value="<?= @$guest_count ?>">
                                        <div class="text-danger"><?= @$message["error_guest_count"] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="hall">Hall</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <select class="form-control" name="hall" id="hall">
                                            <option value="">Select a Hall</option>
                                            <?php
                                            $db = dbConn();
                                            $sql = "SELECT * FROM hall";
                                            if (!empty(@$guest_count)) {
                                                $sql = "SELECT * FROM hall WHERE min_capacity <= $guest_count AND max_capacity >= $guest_count";
                                            }
                                            $result = $db->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <option value=<?= $row['hall_id']; ?> <?php if ($row['hall_id'] == @$hall) { ?> selected <?php } ?>><?= $row['hall_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="text-danger"><?= @$message["error_hall"] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label" for="availability">Availability</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" readonly name="availability" id="availability" value="<?= @$availability ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" name="action" value="event_details" class="btn btn-success" style="width:200px;">Next<i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php include('../customer/footer.php') ?>
<?php ob_end_flush() ?>