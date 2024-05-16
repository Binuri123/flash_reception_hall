<?php ob_start() ?>
<?php include '../customer/header.php'; ?>
<?php include('../customer/sidebar.php') ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    var_dump($_POST);
    $package = $_POST['package'];

    $db = dbConn();
    //echo 'connected';
    $cDate = date('Y-m-d');
    $reservation_no = $_SESSION['reservation_details']['event_details']['reservation_no'];
    $sql = "UPDATE reservation SET package_id='$package' WHERE reservation_no='$reservation_no'";
    print_r($sql);
    $db->query($sql);
    $_SESSION['package_details'] = $package;
    header('Location:add_on.php');
}
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Reservation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 tabs">
                <ul  class="nav nav-tabs">
                    <li  class="nav-item"><a class="nav-link" href="?tab=1">Event Details</a></li>
                    <li  class="nav-item"><a class="nav-link" href="?tab=2">Package</a></li>
                    <li  class="nav-item"><a class="nav-link" href="?tab=3">Add-ons</a></li>
                    <li  class="nav-item"><a class="nav-link active" href="?tab=4">Invoice</a></li>
                </ul>
                <div class="tab-pane container active">
                    <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mt-3">
                                        <label class="form-label" for="hall_charges">Hall Charges</label>
                                    </div>
                                    <div class="col-md-8 mb-3 mt-3">
                                        <input class="form-control" readonly type="text" name="hall_charges" id="hall_charges" value="<?= @$hall_charges ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mt-3">
                                        <label class="form-label" for="package_price">Package Price</label>
                                    </div>
                                    <div class="col-md-8 mb-3 mt-3">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT price,service_charge FROM package WHERE package_id=(SELECT package_id FROM reservation WHERE reservation_no=".$_SESSION['reservation_details']['event_details']['reservation_no'].")";
                                        $result = $db->query($sql);
                                        $row = $result->fetch_assoc();
                                        @$package_price = $row['price'] + $row['price'] * $row['service_charge'] / 100;
                                        ?>
                                        <input class="form-control" readonly type="text" name="package_price" id="package_price" value="<?= @$package_price ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mt-3">
                                        <label class="form-label" for="addon_price">Price of Add-ons</label>
                                    </div>
                                    <div class="col-md-8 mb-3 mt-3">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT item_id FROM extras WHERE reservation_no=".$_SESSION['reservation_details']['event_details']['reservation_no'];
                                        $result = $db->query($sql);
                                        if($result->num_rows>0){
                                            @$addon_price = 0;
                                            while($row=$result->fetch_assoc()){
                                                $sql = "SELECT portion_price FROM menu_item WHERE item_id=".$row['item_id'];
                                                $result_addon_price = $db->query($sql);
                                                @$addon_price += $row['portion_price'];
                                            }
                                        }
                                        ?>
                                        <input class="form-control" readonly type="text" name="addon_price" id="addon_price" value="<?= @$addon_price ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mt-3">
                                        <label class="form-label" for="tax">Tax Rate</label>
                                    </div>
                                    <div class="col-md-8 mb-3 mt-3">
                                        <?php
                                        $db = dbConn();
                                        $sql = "SELECT tax_rate FROM tax";
                                        $result = $db->query($sql);
                                        @$tax=$result->fetch_assoc();
                                        ?>
                                        <input class="form-control" readonly type="text" name="tax" id="tax" value="<?= @$tax ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mt-3">
                                        <label class="form-label" for="taxed_price">Price after Tax</label>
                                    </div>
                                    <div class="col-md-8 mb-3 mt-3">
                                        <?php
                                            if(!empty(@$package_price)&&!empty(@$tax)){
                                                @$taxed_price = @$package_price+@$addon_price+(@$package_price+@$addon_price)*@$tax/100;
                                            }
                                        ?>
                                        <input class="form-control" readonly type="text" name="taxed_price" id="taxed_price" value="<?= @$taxed_price ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mt-3">
                                        <label class="form-label" for="discount">Discount</label>
                                    </div>
                                    <div class="col-md-8 mb-3 mt-3">
                                        <?php
                                            $db = dbConn();
                                            $sql = "SELECT * FROM discount WHERE availability = 'Available'";
                                            $result = $db->query($sql);
                                            if($result->num_rows>0){
                                             $row = $result->fetch_assoc();
                                             @$discount = $row['discount_ratio'];
                                            }else{
                                                @$discount = 0;
                                            }
                                        ?>
                                        <input class="form-control" readonly type="text" name="discount" id="discount" value="<?= @$discount ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mt-3">
                                        <label class="form-label" for="discounted_price">Discounted Price</label>
                                    </div>
                                    <div class="col-md-8 mb-3 mt-3">
                                        <?php
                                            if(!empty(@$discount)){
                                                @$discounted_price = @$taxed_price+(@$taxed_price)*@$discount/100;
                                            }
                                        ?>
                                        <input class="form-control" readonly type="text" name="discounted_price" id="discounted_price" value="<?= @$discounted_price ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align:right">
                                <button type="submit" name="action" value="invoice_details"  class="btn btn-success" style="width:200px;">Make Reservation</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include '../customer/footer.php'; ?>
<?php ob_end_flush() ?>