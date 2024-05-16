<?php ob_start(); ?>
<?php include '../dashboardheader.php'; ?>
<?php include '../dashboardsidebar.php'; ?>

<main id="main" class="main">
    
    <div class="pagetitle">
      <h1>Payment</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="indexcustomer.php">Home</a></li>
          <li class="breadcrumb-item active">Refund Payment</li>
         
        
        </ol>
      </nav>
    </div>
 
 <section class="section dashboard">
      <div class="row">
       
        <div class="col-md-12">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
               
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                             <div class="card-title text-center"><h3>Refund Payment Request </h3>
                                 <br><!-- comment --> 
                                 
                    
                    </div>
                        </div> 
                         <div class="col-md-3">
                            <!-- Button trigger modal -->
<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  View Refund Policy
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Refund Payment Policy</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <strong> Cancellation and Refund Eligibility: </strong> <br> 
          <br>
1. Cancellations made at least 14 days before the scheduled event date are eligible for a full refund.
<br>
<br>
2. Cancellations made less than 14 days before the scheduled event date or after the scheduled event date may not be eligible for a refund, if advance amount paid.
<br>
<br>
3. Cancellations made less than 14 days before the scheduled event date or after scheduled event date will be refunded 80% of the if total amount paid.
<br><!-- comment --> 
<br>


<strong> Force Major or Unforeseen Circumstances: </strong> <br>
<br>
4. In the event of force major events or circumstances beyond our control, such as natural disasters, government-mandated restrictions, or public health emergencies, we reserve the right to modify the refund policy accordingly. We will work with clients to find suitable alternatives or reschedule the event if possible.
<br> 
<br>
<strong> Refund Timeline: <br> </strong> <br>
5. Refunds will be processed within 14 business days from the date of cancellation request.
<br> 
<br>


</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div> 
                         </div>
                        
                    </div>
                    <div class="row">
                        <strong class="text-danger text-center"> 
                                 <?php
                                 if(@$paidamount == @$requestamount){
                                 echo "Your Cancellations made at least 14 days before the scheduled event date therefore you are eligible for a full refund.";
                                 } else {
                                  echo "Your Cancellations made less than 14 days before the scheduled event date or after scheduled event date therefore you will be refunded 80% of the if total amount paid.
";   
                                 }
                                 
                                 
                                 ?>
                                 
                                 
                                 </strong>
                    </div>
                    
                   
                    
        <div class="row mt-3">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
              <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        extract($_GET);
        //    var_dump($_GET);

        $db = dbConn();
        $sql = "SELECT * FROM tbl_customerpayments WHERE ReservationNo='$ReservationNo'";
        //  print_r($sql);
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $ReservationNo = $row['ReservationNo'];
                $lastresprice = $row['LastReservationPrice'];
             //   $PaymentId = $row['PaymentId'];
               

                
            }
        }
    }

    extract($_POST);
    // var_dump($_FILES);
    if ($_SERVER['REQUEST_METHOD'] == "POST" && @$action == "save") {
      //  var_dump($_POST);
        $message = array();

        if (empty($method)) {
            $message['error_method'] = "Refund Payment Method should be selected..!";
        }
        
        if (!empty($method) && $method == 1) {
            if (empty($cashcollect)) {
                $message['error_cashcollect'] = "Cash Collector should be selected..!";
            }
   
        }
        
        if (!empty($cashcollect) && $cashcollect == 2) {
            if (empty($collectorname)) {
                $message['error_collectorname'] = "Collector Name should be enter..!";
            } 
            
            if (empty($collectornic)) {
                $message['error_collectornic'] = "Collector NIC should not be blank..!";
            } elseif (nicValidation($collectornic)) {
                $message['error_collectornic'] = "Invalid Nic Format";
            }
   
        }

        
        if (!empty($method) && $method == 2) {
            if (empty($bank)) {
                $message['error_bank'] = "Bank Name should be selected..!";
            }

            if (empty($branch)) {
                $message['error_branch'] = "Branch Name should be Enter..!";
            }
            
            if (empty($accnumber)) {
                $message['error_accnumber'] = "Account Number should be Enter..!";
            }
            
            if (empty($accholder)) {
                $message['error_accholder'] = "Account Holder should be Enter..!";
            }
        }

        




        if (empty($message)) {

            $db = dbConn();
            $cdate = date('Y-m-d');
            $userid = $_SESSION['userid'];

          echo  $sql = "INSERT INTO tbl_refundpayment(ReservationNo,ReservationDate,LastReservationPrice,TotalPaidAmount,RefundableAmount,PaymentMethodId,CashCollectorId,CollectPerson,CollectorNIC,BankId,Branch,AccountNo,AccountHolder,Description,RefundStatusId,AddUser,AddDate) "
                        . "VALUES('$ReservationNo','$resdate','$lastresprice','$paidamount','$requestamount','$method','$cashcollect','$collectorname','$collectornic','$bank','$branch','$accnumber','$accholder','$description','1','$userid','$cdate')";
            $db->query($sql);

         //   print_r($sql);

            $refundpaymentid = $db->insert_id;
            $refundno = date('Y') . date('m') . date('d') . $refundpaymentid;

            $sql = "UPDATE tbl_refundpayment SET RefundNo='$refundno' WHERE RefundId='$refundpaymentid'";

            $db->query($sql);

            
            header('Location:addsuccess.php?RefundId=' . $refundpaymentid);
        }
    }
    ?>
              
              <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                 
        



        <div class="row">
            

            <input type="hidden" name="ReservationNo" value="<?= $ReservationNo ?>"> 

            <div class="col-md-2"></div>
            <div class="col-md-8">
              
 <div class="alert bg-secondary-light">
       <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <strong class="text-danger"> Required <span class="text-danger">*</span></strong> 
            </div>
        </div>
                <div class="row mt-2">

                    <div class="col-md-5">
                        <label for="resno" class="form-label">Reservation No</label>
                    </div>

                    <div class="col-md-6">


                        <input type="text" class="form-control" id="resno" name="resno" value="<?= @$ReservationNo ?>" readonly>
                       
                    </div>

                </div>
     
                <div class="row mt-2">
                    <div class="col-md-5 mb-2">
                        <label for="resdate" class="form-label">Reservation Date</label>

                    </div>

                    <div class="col-md-6 mb-2">
                        
                        <?php
                        $db = dbConn();
                        $sql = "SELECT ReservationDate FROM tbl_reservation WHERE ReservationNo='$ReservationNo'";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $resdate = $row['ReservationDate'];
                         }
                 //       $paidamount = $lastresprice * $row['PaymentRatio'];
                        ?>
                        
                        
                        <input type="date" class="form-control" id="resdate" name="resdate" value="<?= @$resdate ?>" readonly>
                      
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-5 mb-2">
                        <label for="lastresprice" class="form-label">Last Reservation Price (Rs)</label>
                    </div>

                    <div class="col-md-6 mb-2">

                        <?php
                        $db = dbConn();
                        $sql = "SELECT LastReservationPrice FROM tbl_reservation WHERE ReservationNo='$ReservationNo'";
                        $result = $db->query($sql);
                        $row = $result->fetch_assoc();

                        @$lastresprice = $row['LastReservationPrice'];
                        ?>


                        <input type="text" class="form-control" id="lastresprice" name="lastresprice" value="<?= @$lastresprice ?>" readonly>
                       

                    </div>
                </div>

                

                <div class="row mt-2">
                    <div class="col-md-5 mb-2">
                        <label for="paidamount" class="form-label">Total Paid Amount (Rs)</label>
                    </div>
                    <div class="col-md-6 mb-2">

                        <?php
                        $db = dbConn();
                        $sql = "SELECT SUM(PaidAmount) FROM tbl_customerpayments WHERE ReservationNo='$ReservationNo' AND PaymentStatusId=2";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $paidamount = $row['SUM(PaidAmount)'];
                         }
                 //       $paidamount = $lastresprice * $row['PaymentRatio'];
                        ?>

                        <input type="text" class="form-control" id="paidamount" name="paidamount" value="<?= @$paidamount ?>" readonly>
                       

                    </div>
                </div>
     
     <div class="row mt-2">
                        <div class="col-md-5 mb-2">

                            <label for="requestamount" class="form-label">Refundable Amount (Rs)</label>

                        </div> 

                        <div class="col-md-6 mb-2">
                            
                        <?php
                        
                        
                        $db = dbConn();
                        $sql = "SELECT ReservationDate FROM tbl_reservation WHERE ReservationNo='$ReservationNo'";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $reservationdate = $row['ReservationDate'];
                        
                        $requestdate = date('Y-m-d');
                        
                        $mindate = date('Y-m-d', strtotime($reservationdate . ' -14 days')); // Calculate the selected date

                        }
                        
                        if($requestdate < $mindate){
                         $requestamount = $paidamount;   
                            
                        } else {
                            
                        $db = dbConn();
                        $sql = "SELECT PaymentRatio FROM tbl_paymentcategory WHERE PaymentCategoryId=1";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        
                        $advancepayment = $lastresprice * $row['PaymentRatio'];  
                      
                        }
                        
                        $db = dbConn();
                        $sql = "SELECT PaymentRatio FROM tbl_paymentcategory WHERE PaymentCategoryId=4";
                        $result = $db->query($sql);
                        
                        if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        
                        $fullpayment = $lastresprice * $row['PaymentRatio'];  
                        }
                        if($paidamount == $advancepayment){
                            $requestamount = 0;
                        } elseif($paidamount == $fullpayment) {
                            $requestamount = $fullpayment - $advancepayment ; 
                        }
                        
                            
                            
                        }
                          
                            
                            ?>
                            
                            
                           

                            <input type="text" class="form-control" id="requestamount" name="requestamount" value="<?= @$requestamount ?>" readonly>
                            

                        </div>

                    </div>
     
     <div class="row mt-2">
                        <div class="col-md-5 mb-2">
                            <label for="paymentmethod" class="form-label">Refund Payment Method  <span class="text-danger"><strong>*</strong></span></label>

                        </div> 

                        <div class="col-md-6 mb-2">

                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM tbl_paymentmethod WHERE PaymentMethodId!=4";
                            $result = $db->query($sql);
                            ?>

                            <select class="form-select" id="method" name="method" onchange="form.submit()">
                                <option value="">Select Payment Method</option>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value=<?= $row['PaymentMethodId']; ?> <?php if ($row['PaymentMethodId'] == @$method) { ?>selected <?php } ?>><?= $row['PaymentMethod'] ?></option>


                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <div class="text-danger">
                                <?= @$message['error_method'] ?>  
                            </div>
                        </div>
                    </div>
     
     <?php
                    if (@$method == 2) {
                        ?>

                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="bank" class="form-label">Bank Name  <span class="text-danger"><strong>*</strong></span></label>  
                            </div>

                            <div class="col-md-6">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_bank";
                                $result = $db->query($sql);
                                ?>

                                <select class="form-select" id="bank" name="bank">
                                    <option value="">Select Bank</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>

                                            <option value=<?= $row['BankId']; ?> <?php if ($row['BankId'] == @$bank) { ?>selected <?php } ?>><?= $row['BankName'] ?></option>


                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="text-danger">
                                    <?= @$message['error_bank'] ?>  
                                </div>

                            </div>

                        </div>

                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="branch" class="form-label">Branch Name  <span class="text-danger"><strong>*</strong></span></label>

                            </div>

                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="branch" name="branch" value="<?= @$branch ?>">
                                <div class="text-danger">
                                    <?= @$message['error_branch'] ?>  
                                </div>  
                            </div>
                        </div>
                
                
                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="accnumber" class="form-label">Account No  <span class="text-danger"><strong>*</strong></span></label>

                            </div>

                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="accnumber" name="accnumber" value="<?= @$accnumber ?>">
                                <div class="text-danger">
                                    <?= @$message['error_accnumber'] ?>  
                                </div>  
                            </div>
                        </div>
                
                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="accholder" class="form-label">Account Holder Name  <span class="text-danger"><strong>*</strong></span></label>

                            </div>

                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="accholder" name="accholder" value="<?= @$accholder ?>">
                                <div class="text-danger">
                                    <?= @$message['error_accholder'] ?>  
                                </div>  
                            </div>
                        </div>



                        <?php
                    } elseif (@$method == 1) {
                       ?>
                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="cashcollect" class="form-label">Cash Collect By <span class="text-danger"><strong>*</strong></span></label>  
                            </div>

                            <div class="col-md-6">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM tbl_cashcollect";
                                $result = $db->query($sql);
                                ?>

                                <select class="form-select" id="cashcollect" name="cashcollect" onchange="form.submit()">
                                    <option value="">Select Cash Collector</option>

                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>

                                            <option value=<?= $row['CashCollectorId']; ?> <?php if ($row['CashCollectorId'] == @$cashcollect) { ?>selected <?php } ?>><?= $row['CollectorName'] ?></option>


                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="text-danger">
                                    <?= @$message['error_cashcollect'] ?>  
                                </div>

                            </div>

                        </div>
                        
                        <?php
                        
                        if(@$cashcollect == 2){
                            ?>
     
                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="collectorname" class="form-label">Collector Name  <span class="text-danger"><strong>*</strong></span></label>

                            </div>

                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="collectorname" name="collectorname" value="<?= @$collectorname ?>">
                                <div class="text-danger">
                                    <?= @$message['error_collectorname'] ?>  
                                </div>  
                            </div>
                        </div> 
                        
                        <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="collectornic" class="form-label">Collector NIC  <span class="text-danger"><strong>*</strong></span></label>

                            </div>

                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" id="collectornic" name="collectornic" value="<?= @$collectornic ?>">
                                <div class="text-danger">
                                    <?= @$message['error_collectornic'] ?>  
                                </div>  
                            </div>
                        </div> 
     
                        
                        <?php
                        } 
                            ?>
                        
                            <?php
                     
                        
                    }
                    ?>
                
                
                <div class="row mt-2">
                            <div class="col-md-5 mb-2">
                                <label for="description" class="form-label">Description</label>

                            </div>

                            <div class="col-md-6 mb-2">
                                <textarea class="form-control" id="description" name="description"><?= @$description ?></textarea>

                            </div>
                </div>
                
                
              

                <div class="row mt-2">
                    <div class="col-md-7"></div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success" style="width: 150px" name="action" value="save">Submit</button>

                    </div>
                </div>



                


            </div>
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
      </div>
    </section>    
    
</main>
  

  

  <!-- ======= Footer ======= -->
  <?php include '../dashboardfooter.php'; ?>
<?php ob_end_flush(); ?>