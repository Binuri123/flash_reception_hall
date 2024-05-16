<?php
ob_start();
?>
<?php include '../customer/header.php'; ?>
<?php include '../customer/sidebar.php'; ?>

<main id="main" class="col-md-10 ms-sm-auto col-lg-11 px-md-4">
    <section>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Reservation Management </h1>
            <!--        <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-success"><span data-feather="plus-circle" class="align-text-bottom"></span>New Employee</button>
                            <button type="button" class="btn btn-sm btn-outline-warning"><span data-feather="edit" class="align-text-bottom"></span>Update Employee</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle">
                            <span data-feather="user" class="align-text-bottom"></span>
                            Search Employee
                        </button>
                    </div>-->
        </div>




        <body>
            <ul class="nav nav-tabs">
                <li class="nav-link"><a href="?tab=reservation">Reservation Details</a></li>
                <li class="nav-link"><a href="?tab=package">Package Details</a></li>
                <li class="nav-link"><a href="?tab=payment">Payment Details</a></li>
            </ul>

            <?php
            $tab = isset($_GET['tab']) ? $_GET['tab'] : 'reservation';

            if ($tab == 'reservation') {
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
                            <a href="?tab=package" class="btn btn-success" style="width: 180px" name="action" value="next">Next</a>


                        </div>
                    </div>

            <?php } elseif ($tab == 'package') {
                ?> 

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

                                        <select class="form-select" id="menupackage" name="menupackage" onchange="form.submit()">
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
                        <div class="col-md-8"></div>

                        <div class="col-md-4">
                            <a href="?tab=reservation" class="btn btn-secondary" style="width: 180px" name="action" value="previous">Previous</a>
                            <a href="?tab=payment" class="btn btn-success" style="width: 180px" name="action" value="next">Next</a>



                        </div>
                    </div>
                        
                    </div>

                  

               
            <?php } elseif ($tab == 'payment') {
                ?>
               

                    <div class="row mt-4">

                        <div class="col-md-3">
                             <img src="assets/img/logo.jpg" width="250px" height="250px" alt="alt"/>
                        </div>

                        <div class="col-md-6">

                            <div class="row">
                                
                                 <div class="col-md-12 mb-2">
                                    <label for="totalreservation" class="form-label">Total Reservation Price (Rs)</label>
                                    <input type="text" class="form-control" id="totalreservation" name="totalreservation" value="<?= @$totalreservation ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_totalreservation'] ?>  
                                    </div>



                                </div>
                                
                                 <div class="col-md-12 mb-2">
                                    <label for="tax" class="form-label">Tax (%)</label>
                                    <input type="text" class="form-control" id="tax" name="tax" value="<?= @$tax ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_tax'] ?>  
                                    </div>



                                </div>
                                
                                <div class="col-md-12 mb-2">
                                    <label for="lastresprice" class="form-label">Last Reservation Price (Rs)</label>
                                    <input type="text" class="form-control" id="lastresprice" name="lastresprice" value="<?= @$lastresprice ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_lastresprice'] ?>  
                                    </div>



                                </div>
                                
                                <div class="col-md-12 mb-2">
                                    <label for="paymentcategory" class="form-label">Payment Category</label>

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

                               

                                <div class="col-md-12 mb-2">
                                    <label for="paidamount" class="form-label">Paid Amount (Rs)</label>
                                    <input type="text" class="form-control" id="paidamount" name="paidamount" value="<?= @$paidamount ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_paidamount'] ?>  
                                    </div>

                                </div>
                                
                                <div class="col-md-12 mb-2">
                                    <label for="balanceamount" class="form-label">Balance Amount (Rs)</label>
                                    <input type="text" class="form-control" id="balanceamount" name="balanceamount" value="<?= @$balanceamount ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_balanceamount'] ?>  
                                    </div>

                                </div>
                                
                                  <div class="col-md-12 mb-2">
                                    <label for="paymentmethod" class="form-label">Payment Method</label>

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

                                 <div class="col-md-12 mb-2">
                                    <label for="paiddate" class="form-label">Paid Date</label>
                                    <input type="date" class="form-control" id="paiddate" name="paiddate" value="<?= @$paiddate ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_paiddate'] ?>  
                                    </div>



                                </div>

                               

                                <div class="col-md-12 mb-2">
                                    <label for="image" class="form-label">Payment Slip Image</label>
                                    <input type="file" class="form-control" id="image" name="slipimage" value="<?= @$slipimage ?>">
                                    <div class="text-danger">
                                        <?= @$message['error_slipimage'] ?>  
                                    </div>



                                </div>

                             

                            </div>

                        </div>
                        
                         <div class="col-md-3">
                           
                        </div>
                     
                    </div>


                    <div class="row">
                        <div class="col-md-5"></div>

                        <div class="col-md-6">
                              <a href="?tab=package" class="btn btn-secondary" style="width: 180px" name="action" value="previous">Previous</a>
                           
                            <button type="submit" class="btn btn-success" style="width: 180px" name="action" value="save">Submit</button>
                        </div>
                    </div>








                </form>
            <?php }
            ?>
        </body>



    </section>

</main>



<?php include '../customer/footer.php'; ?> 
<?php ob_end_flush() ?> 

