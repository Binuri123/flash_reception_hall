<?php ob_start() ?>
<?php include '../customer/header.php'; ?>
<?php include('../customer/sidebar.php') ?>

<?php
extract($_POST);
if(isset($item)){
    $additional_price = 0;
    foreach($item as $unit){
        $db = dbConn();
        $sql = "SELECT item_id,portion_price FROM menu_item WHERE item_id='$unit'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $pqty = $portion_qty[$unit];
        $total_portion_price[$unit] = $row['portion_price']*intval($pqty);
        $total_pprice = $total_portion_price[$unit];
        $_SESSION['reservation_details']['additional_items'][$row['item_id']]=array('item_id'=>$row['item_id'],'portion_qty'=>$pqty,'portion_price'=>$row['portion_price'],'total_portion_price'=>$total_portion_price[$unit]);
        $additional_price += $total_portion_price[$unit];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'add_on') {
//var_dump($_POST);
if (!empty($item)) {
$_SESSION['reservation_details']['additional_price'] = $additional_price; 

header('Location:invoice.php');
}
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
        <?php var_dump($_SESSION['reservation_details']);
        ?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card bg-light">
                    <div class="card-header bg-light">
                        <ul class="nav nav-tabs card-header-tabs nav-justified">
                            <li class="nav-item"><a class="nav-link" href="">Event Details</a></li>
                            <li class="nav-item"><a class="nav-link" href="">Package</a></li>
                            <li class="nav-item"><a class="nav-link active" href="?tab=add_ons">Add-ons</a></li>
                            <li class="nav-item"><a class="nav-link" href="">Invoice</a></li>
                        </ul>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mt-3 mb-3">
                                    <div class="card-body">
                                        <div class="tab-container active">
                                            <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                                <div class="row">
                                                    <div class="col-md-5 mt-3">
                                                        <label class="form-label" for="reservation_no">Additional Items</label>
                                                    </div>
                                                    <div class="col-md-7">

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Item Name</th>
                                                                    <th>Portion Price</th>
                                                                    <th></th>
                                                                    <th>Portion Qty</th>
                                                                    <th>Price per Item</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $db = dbConn();
                                                                $sql = "SELECT item_id,item_name,portion_price FROM menu_item WHERE allowed_extra='allowed'";
                                                                //print_r($sql);
                                                                $result = $db->query($sql);
                                                                $i = 1;
                                                                while ($row = $result->fetch_assoc()) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td><?= $row['item_name'] ?></td>
                                                                        <td><?= $row['portion_price'] ?></td>
                                                                        <td>
                                                                            <input class="form-check-input" type="checkbox" id="<?= $row['item_id'] ?>" name="item[]" value="<?= $row['item_id'] ?>" <?php if (isset($item) && in_array($row['item_id'], $item)) { ?>checked <?php } ?>>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                                //echo @$portion_qty[$row['item_id']][$i-1];
                                                                            ?>
                                                                            <input type="number" class="form-control" onchange="updatePrice(<?= $row['item_id'] ?>,<?= $row['portion_price'] ?>,this.value)" name="portion_qty[<?= $row['item_id'] ?>][]" value="<?= @$portion_qty[$row['item_id']] ?>">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" id="amt<?= $row['item_id'] ?>" class="form-control" readonly name="total_portion_price[<?= $row['item_id'] ?>][]" value="<?= @$total_portion_price[$row['item_id']] ?>">
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                                ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><strong>Total</strong></td>
                                                                    <td><?= @$additional_price ?></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6"></div>
                                                    <div class="col-md-6" style="text-align:right">
                                                        <a href="package.php" class="btn btn-success" style="width:150px;"><i class="bi bi-arrow-left"></i> Back</a>
                                                        <button type="submit" name="action" value="add_on"  class="btn btn-success" style="width:150px;">Next <i class="bi bi-arrow-right"></i></button>
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
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php include('../customer/footer.php') ?>
<script>
    function updatePrice(itemid,price,qty){
        $("#amt"+itemid).val(price*qty);
    }
</script>
<?php ob_end_flush() ?>