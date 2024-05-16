 <?php

    // 2nd step- extact the form field 
    // convert array keys to the seperate variable with the value(extract)
    extract($_POST);
       var_dump($_POST);
  //      var_dump($_SESSION['reservation']);

    // 1st step- check the request method  
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
 
        // 3rd step- clean input
       
        $menupackage = cleanInput($menupackage);
        $totalmenuprice = cleanInput($totalmenuprice);
        $totalserviceprice = cleanInput($totalserviceprice);
        $totaladditional = cleanInput($totaladditional);
       

        // Required Validation
        $message = array();

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
        
      
        //  var_dump($message);

        //  var_dump($message);

        if (empty($message)) {
            
            $db = dbConn();

            $userid = $_SESSION['userid'];
            $resid = $_SESSION['reservation_id'];

            $cdate = date('Y-m-d');
            $sql = "UPDATE tbl_reservation SET MenuPackageId='$menupackage',TotalMenuPackagePrice='$totalmenuprice',TotalServicePrice='$totalserviceprice',TotalMenuItemPrice='$totaladditional',UpdateDate='$cdate',UpdateUser='$userid' WHERE ReservationId='$resid'";
                     print_r($sql);

            $db->query($sql);
            
            
            foreach ($service as $value) {
                $sql = "INSERT INTO tbl_resservicelist(ReservationId,ServiceId) VALUES('$resid','$value') ";
                     print_r($sql);
                $db->query($sql);
            }
            
            foreach ($item as $value) {
                $sql = "INSERT INTO tbl_resadditemlist(ReservationId,MenuItemId) VALUES('$resid','$value') ";
                     print_r($sql);
                $db->query($sql);
            }
            

          //  header('Location:addsuccess.php?MenuItemId=' . $newmenuitemid);

            // print_r($sql); 
        }
    }
    ?>    



<form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 

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
                                                                        <input class="form-check-input" type="checkbox" id="<?= $row['MenuItemId'] ?>" name="item[]" value="<?= $row['MenuItemId'] ?>" <?php if (isset($item) && in_array($row['MenuItemId'], $item)) { ?> checked <?php } ?> >
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
                            <a href="?tab=payment" type="submit" name="action" value="package" class="btn btn-success" style="width: 180px" onclick="form.submit()">Next</a>
                                


                        </div>
                    </div>
                        
                    </div>
 </form>