<form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 

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
                                
                                <div class="col-md-12 mb-2">
                                    <label for="resstatus" class="form-label">Reservation Status</label>

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
                                
                                <div class="col-md-12 mb-2">
                                    <label for="paymentstatus" class="form-label">Payment Status</label>

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
                        
                         <div class="col-md-3">
                           
                        </div>
                     
                    </div>


                    <div class="row mt-3">
                        <div class="col-md-5"></div>

                        <div class="col-md-6">
                              <a href="?tab=package" class="btn btn-secondary" style="width: 180px" name="action" value="previous">Previous</a>
                           
                            <button type="submit" class="btn btn-success" style="width: 180px" name="action" value="save">Submit</button>
                        </div>
                    </div>
    
</form>
