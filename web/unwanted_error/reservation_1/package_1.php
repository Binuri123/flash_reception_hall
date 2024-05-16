<?php ob_start() ?>
<?php include '../customer/header.php'; ?>
<?php include('../customer/sidebar.php') ?>
<?php
//var_dump($_SESSION['reservation_details']['event_details']);
?>
<?php
extract($_POST);
print_r($_POST);
echo @$action;
    if($_SERVER['REQUEST_METHOD']=='POST'){
        
        //var_dump($_POST);
        //$package = $_POST['package'];
       
    
    
            $db = dbConn();
            //echo 'connected';
            $cDate = date('Y-m-d');
          $reservation_no =$_SESSION['reservation_details']['event_details']['reservation_no'];
            $sql = "UPDATE reservation package_id='$package' WHERE reservation_no='$reservation_no'";
            //print_r($sql);
            $db->query($sql);
             $_SESSION['package_details'] = $package;
            header('Location:add_on.php?tab='.$next_tab);

    }
    
    
?>
<div class="tab-pane container active">
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
        <?php
        $db = dbConn();
        $sql = "SELECT event_id FROM reservation WHERE reservation_no=" . $_SESSION['reservation_details']['event_details']['reservation_no'];
        //print_r($sql);
        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        $event = $row['event_id'];

        $sql = "SELECT * FROM package p WHERE p.event_id='$event' AND availability='Available'";
        //print_r($sql);
        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="row">
                <div class="col-md-1 mt-2">
                    <input type="radio" name="package" id="<?= $row['package_name'] ?>" value=<?= $row['package_id'] ?> <?php if (isset($package) && $package == $row['package_id']) { ?> checked <?php } ?>>
                </div>
                <div class="col-md-11">
                    <div class="row" for="<?= $row['package_name'] ?>">
                        <div class="col-md-12">
                            <div class="card bg-warning text-dark mb-3">
                                <div class="card-body">
                                    <p><?= $row['package_name'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6" style="text-align:right">
                <input type="text" name="next_tab" value="3">
                <button type="submit" name="action" value="package_details"  class="btn btn-success" style="width:200px;">Next<i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
    </form>
</div>
<?php include '../customer/footer.php'; ?>
<?php ob_end_flush() ?>