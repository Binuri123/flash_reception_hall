<?php //ob_start() ?>
<?php //include '../customer/header.php'; ?>
<?php //include('../customer/sidebar.php') ?>
<?php
//var_dump($_SESSION['reservation_details']['event_details']);
?>
<?php

extract($_POST);
print_r($_POST);
//echo @$action;
    if($_SERVER['REQUEST_METHOD']=='POST'){
        
        var_dump($_POST);
        //$package = $_POST['package'];
       
    
    
            $db = dbConn();
            //echo 'connected';
            $cDate = date('Y-m-d');
          //$reservation_no =$_SESSION['reservation_details']['event_details']['reservation_no'];
            $sql = "UPDATE reservation SET package_id='$event_pack' WHERE reservation_no='$reservation_no'";
            //print_r($sql);
            $db->query($sql);
             //$_SESSION['package_details'] = $event_pack;
            header('Location:add.php?tab='.$next_tab.'&db=connected');

    }
    
    
?>
<div class="tab-pane container active">
   <?php
    extract($_POST);
print_r($_POST);
   ?>
    <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4 mb-3 mt-3">
                        <label class="form-label" for="reservation_no">Reservation No</label>
                    </div>
                    <div class="col-md-8 mb-3 mt-3">

                        <input class="form-control" readonly type="text" name="reservation_no" id="reservation_no" value="<?= $_SESSION['reservation_details']['event_details']['reservation_no'] ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="event_pack">package</label>
            </div>
            <div class="col-md-6">
                <input type="text" name="event_pack" value="2" id="event_pack">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6" style="text-align:right">
                <input type="text" name="next_tab" value="3">
                <button type="submit" name="action" value="package_details"  class="btn btn-success" style="width:200px;">Next<i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
    </form>
</div>
<?php //include '../customer/footer.php'; ?>
<?php //ob_end_flush() ?>