<?php
ob_start();
session_start();
include '../header.php';
?>
<main id="main">
    <section style="margin-top:20px;font-size:13px;">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            extract($_GET);
        }
        extract($_POST);
        $db = dbConn();
        $sql = "SELECT * FROM reservation WHERE reservation_no ="
                . "(SELECT reservation_no FROM arrangement_plan WHERE arrangement_plan_id="
                . "(SELECT arr_plan_id FROM arr_assign_supplier WHERE arr_assign_supplier_id = '$arr_supplier_assign_id'))";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'confirmation') {
            //Required Field Validation
            $message = array();
            if(empty($response)){
                $message['error_response'] = "Confirmation Status Should be Selected...";
            }
            //var_dump($message);
            if (empty($message)) {
                $cDate = date('Y-m-d');
                
                if($response == 'Confirm'){
                    $sql = "UPDATE arr_assign_supplier SET assign_status_id='2',respond_date='$cDate' WHERE arr_assign_supplier_id='$arr_supplier_assign_id'";
                }elseif($response == 'Reject'){
                    $sql = "UPDATE arr_assign_supplier SET assign_status_id='3',respond_date='$cDate' WHERE arr_assign_supplier_id='$arr_supplier_assign_id'";
                }
                
                $db->query($sql);

                header('location:confirmation_success.php');
            }
        }
        ?>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card bg-light" style="font-size:13px;">
                    <div class="card-header">
                        <h3>Confirmation</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                            <div class="row">
                                <div class="col-md-5 mt-3">
                                    <label class="form-label" for="reservation_no">Reservation No</label>
                                </div>
                                <div class="col-md-7 mt-3">
                                    <div><?= $row['reservation_no'] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label" for="reservation_date">Reservation Date</label>
                                </div>
                                <div class="col-md-7">
                                    <div><?= $row['event_date'] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label" for="event">Event</label>
                                </div>
                                <div class="col-md-7">
                                    <?php
                                    $db = dbConn();
                                    $sql_event = "SELECT event_name FROM event WHERE event_id='" . $row['event_id'] . "'";
                                    $result_event = $db->query($sql_event);
                                    $row_event = $result_event->fetch_assoc();
                                    $event = $row_event['event_name'];
                                    ?>
                                    <div><?= @$event ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label" for="event">Hall</label>
                                </div>
                                <div class="col-md-7">
                                    <?php
                                    $db = dbConn();
                                    $sql_hall = "SELECT hall_name FROM hall WHERE hall_id='" . $row['hall_id'] . "'";
                                    $result_hall = $db->query($sql_hall);
                                    $row_hall = $result_hall->fetch_assoc();
                                    $hall = $row_hall['hall_name'];
                                    ?>
                                    <div><?= @$hall ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mt-2">
                                    <label class="form-label"><span class="text-danger">*</span> <strong>Confirmation</strong></label>
                                </div>
                                <div class="col-md-7 mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="response" id="confirmed" value="Confirm" <?php if (isset($response) && @$response == 'Confirm') { ?> checked <?php } ?> style="font-size:13px;">
                                        <label class="form-check-label" for="confirmed"><strong>Confirm</strong></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="response" id="rejected" value="Reject" <?php if (isset($response) && (@$response == 'Reject')) { ?> checked <?php } ?> style="font-size:13px;">
                                        <label class="form-check-label" for="rejected"><strong>Reject</strong></label>
                                    </div>
                                    <div class="text-danger"><?= @$message["error_response"] ?></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="text-align:right">
                                    <input type="hidden" name="arr_supplier_assign_id" value="<?= @$arr_supplier_assign_id ?>">
                                    <button type="submit" name="action" value="confirmation" style="width:100px;font-size:13px;" class="btn btn-sm btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </section>
</main>
<?php
include '../footer.php';
ob_end_flush();
?>
