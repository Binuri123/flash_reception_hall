
<?php

    // 2nd step- extact the form field 
    // convert array keys to the seperate variable with the value(extract)
    extract($_POST);
       var_dump($_POST);
       // var_dump($_SESSION['reservation']);

    // 1st step- check the request method  
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
 
       
        // 3rd step- clean input
        $event = cleanInput($event);
        $resdate = cleanInput($resdate);
        $stime = cleanInput($stime);
        $endtime = cleanInput($endtime);
        $duration = cleanInput($duration);
        $hall = cleanInput($hall);
        $guest = cleanInput($guest);
        
        
          

        // Required Validation
        $message = array();

        if (empty($event)) {
            $message['error_event'] = "Should be Select Event..!";
        }
        
        if (empty($resdate)) {
            $message['error_resdate'] = "Should be Select Reservation Date..!";
        }

        if (empty($stime)) {
            $message['error_stime'] = "Should be Select Reservation Start Time..!";
        } 

        if (empty($endtime)) {
            $message['error_endtime'] = "Should be Select Reservation End Time..!";
        } 


        if (empty($duration)) {
            $message['error_duration'] = "Duration should not be blank..!";
        } 

        if (empty($hall)) {
            $message['error_hall'] = "Should be Select Hall..!";
        } 

        if (empty($guest)) {
            $message['error_guest'] = "Guest Count should not be blank..!";
        }
        
        

        //  var_dump($message);


       
        //  var_dump($message);

        if (empty($message)) {
            
            $db = dbConn();

            $userid = $_SESSION['userid'];

            $cdate = date('Y-m-d');
            $sql = "INSERT INTO tbl_reservation(EventId,ReservationDate,FunctionStartTime,FunctionEndTime,Duration,HallId,GuestCount,AddDate,AddUser)"
                    . "VALUES('$event','$resdate','$stime','$endtime','$duration','$hall','$guest','$cdate','$userid')";
                print_r($sql);

            $db->query($sql);

            $newreservationid = $db->insert_id;
            $_SESSION['reservation_id'] = $newreservationid ;
            
            // generate reservation no 
            $resno = date('Y').date('m').date('d').$newreservationid;
            
            $sql="UPDATE tbl_reservation SET ReservationNo='$resno' WHERE ReservationId='$newreservationid'";
            $db->query($sql); 
            
          //  header('Location:addsuccess.php?MenuItemId=' . $newmenuitemid);

            // print_r($sql); 
        }
    }
    ?>    



<form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 

 <div class="row mt-4">



                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="event" class="form-label">Event</label>

                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM tbl_event";
                                    $result = $db->query($sql);
                                    ?>

                                    <select class="form-select" id="event" name="event">
                                        <option value="">Select Event</option>

                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>

                                                <option value=<?= $row['EventId']; ?> <?php if ($row['EventId'] == @$event) { ?>selected <?php } ?>><?= $row['EventName'] ?></option>


                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger">
                                        <?= @$message['error_event'] ?>  
                                    </div>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label for="resdate" class="form-label">Reservation Date</label>
                                    <input type="date" class="form-control" id="resdate" name="resdate" value="<?= @$resdate ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_resdate'] ?>  
                                    </div>



                                </div>

                                <div class="col-md-12 mb-2">
                                    <label for="stime" class="form-label">Function Start Time</label>
                                    <input type="time" class="form-control" id="stime" name="stime" value="<?= @$stime ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_stime'] ?>  
                                    </div>

                                </div>

                                <div class="col-md-12 mb-2">
                                    <label for="endtime" class="form-label">Function End Time</label>
                                    <input type="time" class="form-control" id="endtime" name="endtime" value="<?= @$endtime ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_endtime'] ?>  
                                    </div>

                                </div>

                                <div class="col-md-12 mb-2">
                                    <label for="duration" class="form-label">Duration</label>
                                    <input type="text" class="form-control" id="duration" name="duration" value="<?= @$duration ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_duration'] ?>  
                                    </div>

                                </div>
                                
                                <div class="col-md-12 mb-2">
                                    <label for="hall" class="form-label">Hall</label>

                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM tbl_hall";
                                    $result = $db->query($sql);
                                    ?>

                                    <select class="form-select" id="hall" name="hall">
                                        <option value="">Select Hall</option>

                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>

                                                <option value=<?= $row['HallId']; ?> <?php if ($row['HallId'] == @$hall) { ?>selected <?php } ?>><?= $row['HallName'] ?></option>


                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger">
                                        <?= @$message['error_hall'] ?>  
                                    </div>
                                </div>
                                

                                <div class="col-md-12 mb-2">
                                    <label for="guest" class="form-label">Guest Count</label>
                                    <input type="text" class="form-control" id="guest" name="guest" value="<?= @$guest ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_guest'] ?>  
                                    </div>

                                </div>




                            </div>

                        </div>
                        <div class="col-md-6 mt-4">
                            <img src="assets/img/hall5.jpg" width="550px" height="500px" alt="alt"/>
                        </div>

                    </div>
     
                   <div class="row">
                        <div class="col-md-4"></div>

                        <div class="col-md-8">
<!--                            <a href="?tab=package" class="btn btn-success" style="width: 180px" name="action" value="reservation" onclick="form.submit()">Next</a>
-->                            <button type="submit" class="btn btn-success" name="action" value="save">Next</button>

                        </div>
                    </div>
     
</form>
