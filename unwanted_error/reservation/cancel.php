<?php
ob_start();
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main">
    <section>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            extract($_GET);
        }

        extract($_POST);
        var_dump($_POST);
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'cancel_reservation') {

            $message = array();

            if (!isset($cancel_reason)) {
                $message['error_cancel_reason'] = "The Reason for the Cancelation Should be Seleceted...";
            }
            
            if(empty($message)){
                $db = dbConn();
                $cDate = date('Y-m-d');
                $cTime = date('H:i');
                
                if($cancel_reason != 'Other'){
                    $sql = "INSERT INTO canceled_reservations(reservation_no,cancel_reason,canceled_date,cancel_time) VALUES('$reservation_no','$cancel_reason','$cDate','$cTime')";
                }else{
                    $sql = "INSERT INTO canceled_reservations(reservation_no,cancel_reason,canceled_date,cancel_time,other_reason) VALUES('$reservation_no','$cancel_reason','$cDate','$cTime','$other_reason')";
                }
                print_r($sql);
                $db->query($sql);
                
                $sql = "UPDATE reservation SET reservation_status_id ='3',update_date ='$cDate' WHERE reservation_no = '$reservation_no'";
                $db->query($sql);
                
                header('location:cancel_success.php?reservation_no='.$reservation_no);
            }
        }
        ?>
        <div class="pagetitle">
            <h1>Reservation</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>reservation/reservation.php">Reservation</a></li>
                    <li class="breadcrumb-item active">Cancel Reservation</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card bg-white">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Cancel Reservation</h4>
                            </div>
                            <div class="col-md-6" style="text-align:right;font-size:13px;">
                                <span class="text-danger">* Required</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="font-size:13px;">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                    <div class="row">
                                        <div class="col-md-4 mt-3 mb-3">
                                            <label class="form-label">Reservation No</label>
                                        </div>
                                        <div class="col-md-1 mt-3 mb-3">:</div>
                                        <div class="col-md-7 mt-3 mb-3">
                                            <div><?= @$reservation_no ?></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label"><span class="text-danger">*</span> Reason for Cancellation</label>
                                        </div>
                                        <div class="col-md-1 mb-3">:</div>
                                        <div class="col-md-7 mb-3">
                                            <?php
                                            $db = dbConn();
                                            $sql = "SELECT * FROM cancelation_reasons";
                                            $result = $db->query($sql);
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="cancel_reason" id="<?= $row['reason'] ?>" value="<?= $row['reason'] ?>" <?php if (isset($cancel_reason) && @$cancel_reason == $row['reason']) { ?> checked <?php } ?> style="font-size:13px;" onchange="form.submit()">
                                                    <label class="form-check-label" for="<?= $row['reason'] ?>"><?= $row['reason'] ?></label>
                                                </div><br>
                                                <?php
                                            }
                                            ?>
                                                <div class="text-danger"><?= @$message['error_cancel_reason'] ?></div>
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($cancel_reason) && $cancel_reason == 'Other') {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Your Reason</label>
                                            </div>
                                            <div class="col-md-1 mb-3">:</div>
                                            <div class="col-md-7 mb-3">
                                                <textarea class="form-control" placeholder="You can mention the reason here..." name="other_reason" value='<?= @$other_reason ?>' style="font-size:13px;"></textarea>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align:right;">
                                            <input type="hidden" name="reservation_no" value="<?= @$reservation_no ?>">
                                            <button class="btn btn-success btn-sm" style="font-size:13px;width:100px;" name="action" value="cancel_reservation">Send</button>
                                            <a href="<?= WEB_PATH ?>reservation/cancel.php?reservation_no=<?= @$reservation_no ?>" class="btn btn-warning btn-sm" style="font_size:13px;width:100px;">Clear</a>
                                        </div>
                                    </div>
                                </form>
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