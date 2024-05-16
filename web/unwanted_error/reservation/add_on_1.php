<?php ob_start() ?>
<?php include '../customer/header.php'; ?>
<?php include('../customer/sidebar.php') ?>

<?php
extract($_POST);
print_r($item);
if (!empty($item)) {
        foreach($item as $value){
            $db = dbConn();
            $sql = "SELECT * FROM menu_item WHERE item_id='$value'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $_SESSION['reservation_details']['additional_items'][$row['item_id']]=array('item_id'=>$row['item_id'],'portion_qty'=>'','portion_price'=>$row['portion_price'],'total_portion_price'=>'');
        }
}

if (!empty(@$item)) {
    @$additional_price = 0;

    foreach (@$item as $value) {
        $db = dbConn();
        $sql = "SELECT portion_price FROM menu_item WHERE item_id='$value'";
        //print_r($sql);
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        @$additional_price += $row['portion_price'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'add_on') {

//var_dump($_POST);

if (!empty($item)) {

//        foreach($item as $value){
//            $db = dbConn();
//            $sql = "SELECT * FROM menu_item WHERE item_id='$value'";
//            $result = $db->query($sql);
//            $row = $result->fetch_assoc();
//            $_SESSION['reservation_details']['additional_items'][$row['item_id']]=array('item_id'=>$row['item_id'],'portion_qty'=>'','portion_price'=>$row['portion_price'],'total_portion_price'=>'');
//        }
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
        <?php //var_dump($_SESSION['reservation_details']); ?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card bg-light">
                    <div class="card-header bg-light    ">
                        <ul class="nav nav-tabs card-header-tabs nav-justified">
                            <li class="nav-item"><a class="nav-link" href="?tab=event_details">Event Details</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=package">Package</a></li>
                            <li class="nav-item"><a class="nav-link active" href="?tab=add_ons">Add-ons</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=invoice">Invoice</a></li>
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
                                                                    <th></th>
                                                                    <th></th>
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
                                                                            <input class="form-check-input" onchange="form.submit()" type="checkbox" id="<?= $row['item_id'] ?>" name="item[]" value="<?= $row['item_id'] ?>" <?php if (isset($item) && in_array($row['item_id'], $item)) { ?>checked <?php } ?>>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control" name="portion_qty[]" onchange="form.submit()" value="<?= @$portion_qty ?>" max="<?= $_SESSION['reservation_details']['event_details']['guest_count'] ?>">
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if (!empty(@$item) && !empty(@$portion_qty)) {
                                                                                @$total_portion_price = $row['portion_price'] * @$portion_qty;
                                                                            }
                                                                            ?>
                                                                            <input type="text" class="form-control" readonly name="total_portion_price[]" value="<?= @$total_portion_price ?>">
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
<?php ob_end_flush() ?>