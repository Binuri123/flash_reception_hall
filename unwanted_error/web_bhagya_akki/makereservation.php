<?php
ob_start();
if(!isset($_SESSION['user_id'])){
    header('Location:login.php');
}
?>
<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>

<main id="main" class="col-md-10 ms-sm-auto col-lg-11 px-md-4">
    <section>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Make Your Reservation</h1>

        </div>

        <?php
//     
        // ignore spaces (trim)     
        //  $Pname=trim($Pname);  
        // remove backslash \
        //  $Pname=stripcslashes($Pname);   
        // 
        //  $Pname= htmlspecialchars($Pname); 
        //  echo $Pname; 
        //  echo $pQty;
        //  echo $Pprice;
        // 2nd step- extact the form field 
        // convert array keys to the seperate variable with the value(extract)
        extract($_POST);
        //  var_dump($_POST);
        //  var_dump($_SESSION['reservation']);
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
            $menupackage = cleanInput($menupackage);
            $totalmenuprice = cleanInput($totalmenuprice);
            $totalserviceprice = cleanInput($totalserviceprice);
            $totaladditional = cleanInput($totaladditional);
            $totalreservation = cleanInput($totalreservation);
            $tax = cleanInput($tax);
            $lastresprice = cleanInput($lastresprice);
            $resstatus = cleanInput($resstatus);

            $paymentcategory = cleanInput($paymentcategory);
            $paidamount = cleanInput($paidamount);
            $balanceamount = cleanInput($balanceamount);
            $paymentmethod = cleanInput($paymentmethod);
            $paiddate = cleanInput($paiddate);
            $paymentstatus = cleanInput($paymentstatus);

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

            if (empty($menupackage)) {
                $message['error_menupackage'] = "Should be select Menu Package..!";
            }

            if (empty($totalmenuprice)) {
                $message['error_totalmenuprice'] = "Total Menu Price should not be blank..!";
            }

            if (empty($totalserviceprice)) {
                $message['error_totalserviceprice'] = "Total Service Price should not be blank..!";
            }

            if (empty($totaladditional)) {
                $message['error_totaladditional'] = "Total Additional Item Price should not be blank..!";
            }

            if (empty($totalreservation)) {
                $message['error_totalreservation'] = "Total Reservation Price should not be blank..!";
            }

            if (empty($tax)) {
                $message['error_tax'] = "Tax should not be blank..!";
            }

            if (empty($lastresprice)) {
                $message['error_lastresprice'] = "Last Reservation Price should not be blank..!";
            }

            if (empty($resstatus)) {
                $message['error_resstatus'] = "Should be select Reservation Status..!";
            }

            if (empty($paymentcategory)) {
                $message['error_paymentcategory'] = "Should be select Payment Category..!";
            }

            if (empty($paidamount)) {
                $message['error_paidamount'] = "Paid Amount should not be blank..!";
            }

            if (empty($balanceamount)) {
                $message['error_balanceamount'] = "Balance Amount should not be blank..!";
            }

            if (empty($paymentmethod)) {
                $message['error_paymentmethod'] = "Should be select Payment Method..!";
            }

            if (empty($paiddate)) {
                $message['error_paiddate'] = "Should be select Paid Date..!";
            }

            if (empty($paymentstatus)) {
                $message['error_paymentstatus'] = "Should be select Payment Status..!";
            }


            //  var_dump($message);


            if (empty($message)) {
                $PaymentSlipImage = $_FILES['slipimage'];

                $filename = $PaymentSlipImage['name'];

                $filetmpname = $PaymentSlipImage['tmp_name'];

                $filesize = $PaymentSlipImage['size'];

                $fileerror = $PaymentSlipImage['error'];

                $fileext = explode(".", $filename);

                $fileext = strtolower(end($fileext));

                $allowedext = array("jpg", "jpeg", "png", "gif");

                if (in_array($fileext, $allowedext)) {

                    if ($fileerror === 0) {
                        if ($filesize <= 2097152) {
                            $file_name_new = uniqid("", true) . "." . $fileext;
                            $file_destination = "assets/img/payments/" . $file_name_new;

                            if (move_uploaded_file($filetmpname, $file_destination)) {
                                echo "The file was uploaded successfully.";
                            } else {
                                $message['error_file'] = "There was an error uploading the file.";
                            }
                        } else {
                            $message['error_file'] = "This File is Invalid ...!";
                        }
                    } else {
                        $message['error_file'] = "This File has Error ...!";
                    }
                } else {

                    $message['error_file'] = "This File Type not Allowed...!";
                }
            }

            //  var_dump($message);

            if (empty($message)) {

                $db = dbConn();

                $userid = $_SESSION['userid'];

                $cdate = date('Y-m-d');
                $sql = "INSERT INTO tbl_reservation(EventId,ReservationDate,FunctionStartTime,FunctionEndTime,Duration,HallId,GuestCount,MenuPackageId,TotalMenuPackagePrice,TotalServicePrice,TotalMenuItemPrice,TotalReservationPrice,Tax,LastReservationPrice,ReservationStatusId,AddDate,AddUser)"
                        . "VALUES('$event','$resdate','$stime','$endtime','$duration','$hall','$guest','$menupackage','$totalmenuprice','$totalserviceprice','$totaladditional','$totalreservation','$tax','$lastresprice','$resstatus','$cdate','$userid')";
                print_r($sql);

                $db->query($sql);

                $newreservationid = $db->insert_id;

                // generate reservation no 
                $resno = date('Y') . date('m') . date('d') . $newreservationid;

                $sql = "INSERT INTO tbl_customerpayments(ReservationNo,PaymentCategoryId,PaidAmount,BalanceAmount,PaymentMethodId,PaidDate,PaymentSlipImage,PaymentStatusId,AddDate,AddUser)"
                        . "VALUES('$resno','$paymentcategory','$paidamount','$balanceamount','$paymentmethod','$paiddate','$file_name_new','$paymentstatus','$cdate','$userid')";
                print_r($sql);

                $db->query($sql);

                $sql = "UPDATE tbl_reservation SET ReservationNo='$resno' WHERE ReservationId='$newreservationid'";
                $db->query($sql);

                foreach ($service as $value) {
                    $sql = "INSERT INTO tbl_resservicelist(ReservationId,ServiceId) VALUES('$newreservationid','$value') ";
                    print_r($sql);
                    $db->query($sql);
                }

                foreach ($item as $value) {
                    $sql = "INSERT INTO tbl_resadditemlist(ReservationId,MenuItemId) VALUES('$newreservationid','$value') ";
                    print_r($sql);
                    $db->query($sql);
                }


                //  header('Location:addsuccess.php?MenuItemId=' . $newmenuitemid);
                // print_r($sql); 
            }
        }
        ?>    


        <div class="container mt-3">

            <br>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#home">Step 1 - Reservation Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#menu1">Step 2 - Package Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#menu2">Step 3 - Payment Details</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="home" class="container tab-pane active"><br>

                    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 

                        <div class="row mt-4">



                            <div class="col-md-6">

                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-5">
                                                    <label for="event" class="form-label">Event</label>
                                            </div>
                                            <div class="col-md-7">
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
                                        </div>
                                    

                                      
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-5">
                                                    <label for="resdate" class="form-label">Reservation Date</label>
                                            </div>
                                            <div class="col-md-7">
                                                 <input type="date" class="form-control" id="resdate" name="resdate" value="<?= @$resdate ?>">
                                        <div class="text-danger">
                                            <?= @$message['error_resdate'] ?>  
                                        </div>
                                            </div>
                                        </div>
                                    
                                       



                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-5">
                                                   <label for="stime" class="form-label">Function Start Time</label>
                                            </div>
                                            <div class="col-md-7">
                                                  <input type="time" class="form-control" id="stime" name="stime" value="<?= @$stime ?>">
                                        <div class="text-danger">
                                            <?= @$message['error_stime'] ?>  
                                        </div>
                                            </div>
                                        </div>
                                     
                                      

                                    </div>

                                    <div class="col-md-12 mb-2">
                                         <div class="row">
                                             <div class="col-md-5">
                                                   <label for="endtime" class="form-label">Function End Time</label>
                                             </div>
                                             <div class="col-md-7">
                                                   <input type="time" class="form-control" id="endtime" name="endtime" value="<?= @$endtime ?>">
                                        <div class="text-danger">
                                            <?= @$message['error_endtime'] ?>  
                                        </div>
                                             </div>
                                        </div>
                                      
                                      

                                    </div>

                                    <div class="col-md-12 mb-2">
                                         <div class="row">
                                             <div class="col-md-5">
                                                   <label for="duration" class="form-label">Duration</label>
                                             </div>
                                             <div class="col-md-7">
                                                   <input type="text" class="form-control" id="duration" name="duration" value="<?= @$duration ?>">
                                        <div class="text-danger">
                                            <?= @$message['error_duration'] ?>  
                                        </div>
                                             </div>
                                        </div>
                                      
                                      

                                    </div>

                                    <div class="col-md-12 mb-2">
                                         <div class="row">
                                             <div class="col-md-5">
                                                   <label for="hall" class="form-label">Hall</label>
                                             </div>
                                            <div class="col-md-7">
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
                                        </div>
                                      

                                       
                                    </div>


                                    <div class="col-md-12 mb-2">
                                         <div class="row">
                                             <div class="col-md-5">
                                                    <label for="guest" class="form-label">Guest Count</label>
                                             </div>
                                             <div class="col-md-7">
                                                  <input type="text" class="form-control" id="guest" name="guest" value="<?= @$guest ?>">
                                        <div class="text-danger">
                                            <?= @$message['error_guest'] ?>  
                                        </div>

                                             </div>
                                        </div>
                                     
                                       
                                    </div>




                                </div>

                            </div>
                         
                            <div class="col-md-5">
<!--                                <img src="assets/img/hall5.jpg" width="500px" height="320px" alt="alt"/>-->
                            </div>

                        </div>  

                        <div class="row">
                            <div class="col-md-4"></div>

                            <div class="col-md-8">
                                <a href="" class="btn btn-success" style="width: 180px" name="action" value="reservation">Next</a>

                                <!--//                                if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == "reservation") {
                                //                                    $_SESSION['reservation']['reservationdetails'] = array('Event' => $event, 'ResDate' => $resdate, 'StartTime' => $stime, 'EndTime' => $endtime, 'Duration' => $duration, 'Hall' => $hall, 'Guest' => $guest);
                                //                                    var_dump($_SESSION['reservation']);
                                //                                }-->


                            </div>
                        </div>

                </div>
                <div id="menu1" class="container tab-pane fade"><br>
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card text-dark bg-transparent mb-3" style="max-width: 28rem;">
                                <div class="card-header bg-secondary text-light">Menu Package</div>
                                <div class="card-body bg-transparent">
                                    <div class="col-md-12">
                                        <label for="menupackage" class="col-form-label">Menu Package Name</label>

                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT * FROM tbl_menupackage";
                                        $result = $db->query($sql);
                                        ?>

                                        <select class="form-select" id="menupackage" name="menupackage">
                                            <option value="">Select Menu Package</option>

                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>

                                                    <option value=<?= $row['MenuPackageId']; ?> <?php if ($row['MenuPackageId'] == @$menupackage) { ?>selected <?php } ?>><?= $row['MenuPackageName'] ?></option>


                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="text-danger">
                                            <?= @$message['error_itemcategory'] ?>  
                                        </div>
                                    </div>




                                    <div class="col-md-12 mb-2 mt-3">
                                        <label for="menuprice" class="form-label">Menu Package Price (Rs)</label>
                                        <input type="text" class="form-control" id="menuprice" name="menuprice" value="<?= @$menuprice ?>">
                                        <div class="text-danger">
                                            <?= @$message['error_menuprice'] ?>  
                                        </div>

                                    </div>

                                    <div class="col-md-12 mb-2 mt-3">
                                        <label for="totalmenuprice" class="form-label">Total Menu Package Price (Rs)</label>
                                        <input type="text" class="form-control" id="totalmenuprice" name="totalmenuprice" value="<?= @$totalmenuprice ?>">
                                        <div class="text-danger">
                                            <?= @$message['error_totalmenuprice'] ?>  
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-dark bg-transparent mb-3" style="max-width: 28rem;">
                                <div class="card-header bg-secondary text-light">Service</div>
                                <div class="card-body bg-transparent">
                                    <div class="row mt-3 mb-2">
                                        <div class="table-responsive">
                                            <?php
//                                   if(!empty(@$itemcategory)){
//    $sql = "SELECT * FROM tbl_menuitem m LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE m.MenuItemCategoryId='$itemcategory'";
//   print_r($sql);
//                                    } else  {
//    echo 'table';
//  print_r($_SESSION['selecteditems']);
                                            $sql = "SELECT * FROM tbl_service";
//  } 
                                            $db = dbConn();
                                            $result = $db->query($sql);
                                            ?>

                                            <table class="table table-sm">
                                                <thead class="bg-transparent">
                                                    <tr>
                                                        <th scope="col"></th>
                                                        <th scope="col">Service Name</th>
                                                        <th scope="col">Service Price (Rs) </th>
                                                        <th scope="col">Select </th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    if ($result->num_rows > 0) {
                                                        //  $totalmenuprice = 0;
                                                        while ($row = $result->fetch_assoc()) {
                                                            // floatval(@$plateprice) += floatval($row['PortionPrice']);
                                                            ?>

                                                            <tr>
                                                                <td></td>
                                                                <td><?= $row['ServiceName'] ?></td>
                                                                <td><?= $row['ServiceLastPrice'] ?></td> 
                                                                <td> <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" id="<?= $row['ServiceId'] ?>" name="service[]" value="<?= $row['ServiceId'] ?>" <?php if (isset($service) && in_array($row['ServiceId'], $service)) { ?> checked <?php } ?> >
                                                                        <label class="form-check-label" for="service"></label>
                                                                    </div>

                                                                </td> 


                                                            </tr>

                                                            <?php
                                                            // $db = dbConn();
                                                            // if(!empty(@$item)){
                                                            //   $sql2= "SELECT SUM(m.PortionPrice) FROM `tbl_mpitemlist` l INNER JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId WHERE MenuPackageId='" . @$MenuPackageId . "'";
                                                            //   @$plateprice = $db->query($sql2);
                                                        }
                                                    }

//}
                                                    ?>


                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-12 mb-2 mt-3">
                                            <label for="totalserviceprice" class="form-label">Total Service Price (Rs)</label>
                                            <input type="text" class="form-control" id="totalserviceprice" name="totalserviceprice" value="<?= @$totalserviceprice ?>">
                                            <div class="text-danger">
                                                <?= @$message['error_totalserviceprice'] ?>  
                                            </div>

                                        </div>




                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card text-dark bg-transparent mb-3" style="max-width: 28rem;">
                                <div class="card-header bg-secondary text-light">Additional Item</div>
                                <div class="card-body bg-transparent">
                                    <div class="row mt-3 mb-2">
                                        <div class="table-responsive">
                                            <?php
//                                   if(!empty(@$itemcategory)){
//    $sql = "SELECT * FROM tbl_menuitem m LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId WHERE m.MenuItemCategoryId='$itemcategory'";
//   print_r($sql);
//                                    } else  {
//    echo 'table';
//  print_r($_SESSION['selecteditems']);
                                            $sql = "SELECT * FROM tbl_menuitem m LEFT JOIN tbl_menuitem_category c ON c.MenuItemCategoryId=m.MenuItemCategoryId";
//  } 
                                            $db = dbConn();
                                            $result = $db->query($sql);
                                            ?>

                                            <table class="table table-sm">
                                                <thead class="bg-transparent">
                                                    <tr>
                                                        <th scope="col"></th>
                                                        <th scope="col">Item Category</th>
                                                        <th scope="col">Menu Item Name</th>
                                                        <th scope="col">Portion Price (Rs) </th>
                                                        <th scope="col">Select </th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    if ($result->num_rows > 0) {
                                                        //  $totalmenuprice = 0;
                                                        while ($row = $result->fetch_assoc()) {
                                                            // floatval(@$plateprice) += floatval($row['PortionPrice']);
                                                            ?>

                                                            <tr>
                                                                <td></td>
                                                                <td><?= $row['CategoryName'] ?></td>
                                                                <td><?= $row['MenuItemName'] ?></td>
                                                                <td><?= $row['PortionPrice'] ?></td> 
                                                                <td> <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" onchange="form.submit()" id="<?= $row['MenuItemId'] ?>" name="item[]" value="<?= $row['MenuItemId'] ?>" <?php if (isset($item) && in_array($row['MenuItemId'], $item)) { ?> checked <?php } ?> >
                                                                        <label class="form-check-label" for="item"></label>
                                                                    </div>

                                                                </td> 


                                                            </tr>

                                                            <?php
                                                            // $db = dbConn();
                                                            // if(!empty(@$item)){
                                                            //   $sql2= "SELECT SUM(m.PortionPrice) FROM `tbl_mpitemlist` l INNER JOIN tbl_menuitem m ON m.MenuItemId=l.MenuItemId WHERE MenuPackageId='" . @$MenuPackageId . "'";
                                                            //   @$plateprice = $db->query($sql2);
                                                        }
                                                    }

//}
                                                    ?>


                                                </tbody>
                                            </table>
                                        </div>


                                        <div class="col-md-12 mb-2 mt-3">
                                            <label for="totaladditional" class="form-label">Total Additional Item Price (Rs)</label>
                                            <input type="text" class="form-control" id="totaladditional" name="totaladditional" value="<?= @$totaladditional ?>">
                                            <div class="text-danger">
                                                <?= @$message['error_totaladditional'] ?>  
                                            </div>

                                        </div>






                                    </div>    

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7"></div>

                            <div class="col-md-5">
                                <a href="?tab=reservation" class="btn btn-secondary" style="width: 180px" name="action" value="previous">Previous</a>
                                <a href="?tab=payment" type="submit" name="action" value="package" class="btn btn-success" style="width: 180px">Next</a>



                            </div>
                        </div>

                    </div>


                </div>
                <div id="menu2" class="container tab-pane fade"><br>
                    <div class="row mt-4">

                        <div class="col-md-3">
                            <img src="assets/img/logo.jpg" width="250px" height="250px" alt="alt"/>
                        </div>

                        <div class="col-md-6">

                            <div class="row">

                                <div class="col-md-12 mb-2">

                                    <div class="row">
                                        <div class="col-md-5">
                                            <label for="totalreservation" class="form-label">Total Reservation Price (Rs)</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" id="totalreservation" name="totalreservation" value="<?= @$totalreservation ?>">
                                            <div class="text-danger">
                                                <?= @$message['error_totalreservation'] ?>  
                                            </div>
                                        </div>
                                    </div>





                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label for="tax" class="form-label">Tax (%)</label> 
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" id="tax" name="tax" value="<?= @$tax ?>">
                                            <div class="text-danger">
                                                <?= @$message['error_tax'] ?>  
                                            </div>
                                        </div>
                                    </div>





                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label for="lastresprice" class="form-label">Last Reservation Price (Rs)</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" id="lastresprice" name="lastresprice" value="<?= @$lastresprice ?>">
                                            <div class="text-danger">
                                                <?= @$message['error_lastresprice'] ?>  
                                            </div>
                                        </div>
                                    </div>





                                </div>



                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label for="paymentcategory" class="form-label">Payment Category</label>
                                        </div>
                                        <div class="col-md-7">
                                            <?php
                                            $db = dbConn();
                                            $sql = "SELECT * FROM tbl_paymentcategory";
                                            $result = $db->query($sql);
                                            ?>

                                            <select class="form-select" id="paymentcategory" name="paymentcategory">
                                                <option value="">Select Payment Category</option>

                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        ?>

                                                        <option value=<?= $row['PaymentCategoryId']; ?> <?php if ($row['PaymentCategoryId'] == @$paymentcategory) { ?>selected <?php } ?>><?= $row['PaymentCategory'] ?></option>


                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="text-danger">
                                                <?= @$message['error_paymentcategory'] ?>  
                                            </div>
                                        </div>
                                    </div>



                                </div>



                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label for="paidamount" class="form-label">Paid Amount (Rs)</label>     
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" id="paidamount" name="paidamount" value="<?= @$paidamount ?>">
                                            <div class="text-danger">
                                                <?= @$message['error_paidamount'] ?>  
                                            </div>
                                        </div>
                                    </div>



                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                               <label for="balanceamount" class="form-label">Balance Amount (Rs)</label>
                                        </div>
                                        <div class="col-md-7">
                                             <input type="text" class="form-control" id="balanceamount" name="balanceamount" value="<?= @$balanceamount ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_balanceamount'] ?>  
                                    </div>

                                        </div>
                                    </div>
                                 
                                   
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                              <label for="paymentmethod" class="form-label">Payment Method</label> 
                                        </div>
                                        <div class="col-md-7">
                                             <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM tbl_paymentmethod";
                                    $result = $db->query($sql);
                                    ?>

                                    <select class="form-select" id="paymentmethod" name="paymentmethod">
                                        <option value="">Select Payment Method</option>

                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>

                                                <option value=<?= $row['PaymentMethodId']; ?> <?php if ($row['PaymentMethodId'] == @$paymentmethod) { ?>selected <?php } ?>><?= $row['PaymentMethod'] ?></option>


                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger">
                                        <?= @$message['error_paymentmethod'] ?>  
                                    </div>
                                        </div>
                                    </div>
                                 

                                   
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                                <label for="paiddate" class="form-label">Paid Date</label>
                                        </div>
                                        <div class="col-md-7">
                                             <input type="date" class="form-control" id="paiddate" name="paiddate" value="<?= @$paiddate ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_paiddate'] ?>  
                                    </div>

                                        </div>
                                    </div>
                                
                                   


                                </div>



                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                                <label for="image" class="form-label">Payment Slip Image</label>
                                        </div>
                                        <div class="col-md-7">
                                            
                                    <input type="file" class="form-control" id="image" name="slipimage" value="<?= @$slipimage ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_slipimage'] ?>  
                                    </div>
                                        </div>
                                    </div>
                                

                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                                 <label for="resstatus" class="form-label">Reservation Status</label>
                                        </div>
                                        <div class="col-md-7">
                                             <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM tbl_reservationstatus";
                                    $result = $db->query($sql);
                                    ?>

                                    <select class="form-select" id="resstatus" name="resstatus">
                                        <option value="">Select Reservation Status</option>

                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>

                                                <option value=<?= $row['ResStatusId']; ?> <?php if ($row['ResStatusId'] == @$resstatus) { ?>selected <?php } ?>><?= $row['ResStatusName'] ?></option>


                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger">
                                        <?= @$message['error_resstatus'] ?>  
                                    </div>
                                        </div>
                                    </div>
                               

                                   
                                </div>

                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                               <label for="paymentstatus" class="form-label">Payment Status</label>
                                        </div>
                                        <div class="col-md-7">
                                              <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM tbl_paymentstatus";
                                    $result = $db->query($sql);
                                    ?>

                                    <select class="form-select" id="paymentstatus" name="paymentstatus">
                                        <option value="">Select Payment Status</option>

                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>

                                                <option value=<?= $row['PaymentStatusId']; ?> <?php if ($row['PaymentStatusId'] == @$paymentstatus) { ?>selected <?php } ?>><?= $row['PaymentStatusName'] ?></option>


                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger">
                                        <?= @$message['error_paymentstatus'] ?>  
                                    </div>
                                        </div>
                                    </div>
                                 

                                  
                                </div>

                            </div>

                        </div>

                        <div class="col-md-3">

                        </div>

                    </div>   

                    <div class="row mt-3">
                        <div class="col-md-6"></div>

                        <div class="col-md-6">
                            <a href="?tab=package" class="btn btn-secondary" style="width: 150px" name="action" value="previous">Previous</a>

                            <button type="submit" class="btn btn-success" style="width: 150px" name="action" value="save">Submit</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        </form>


    </section>

</main>



<?php include 'footer.php'; ?> 
<?php ob_end_flush() ?> 

