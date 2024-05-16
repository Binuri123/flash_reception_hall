<?php ob_start() ?>
<?php include '../customer/header.php'; ?>
<?php include('../customer/sidebar.php') ?>
<?php

extract($_POST);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'add_on') {
    
    //var_dump($_POST);
    
    $db = dbConn();
    foreach ($item as $value){
        $sql = "INSERT INTO extras(reservation_no,item_id) VALUES(".$_SESSION['reservation_details']['event_details']['reservation_no'].",'$value')";
        $db->query($sql);
    }
    
    header('Location:invoice.php?reservation_no='.$reservation_no);
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
                    <li  class="nav-item"><a class="nav-link active" href="?tab=3">Add-ons</a></li>
                    <li  class="nav-item"><a class="nav-link" href="?tab=4">Invoice</a></li>
                </ul>
                <div class="tab-pane container active">
                    <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="row">
                            <div class="col-md-5 mt-3">
                                <label class="form-label" for="reservation_no">Additional Items</label>
                            </div>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mt-3">
                                        <label class="form-label" for="additional_price">Additional Price</label>
                                    </div>
                                    <div class="col-md-8 mb-3 mt-3">
                                        <input type="text" class="form-control" readonly name="additional_price" id="additional_price" value="<?= @$additional_price ?>">
                                    </div>
                                </div>
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
                                                    <input class="form-check-input" onclick="form.submit()" type="checkbox" id="<?= $row['item_id'] ?>" name="item[]" value="<?= $row['item_id'] ?>" <?php if (isset($item) && in_array($row['item_id'], $item)) { ?>checked <?php } ?>>
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
                                                <?php
                                                if (!empty(@$item)) {
                                                    @$additional_price = 0;
                                                    
                                                    foreach (@$item as $value) {
                                                        $db = dbConn();
                                                        $sql = "SELECT portion_price FROM menu_item WHERE item_id='$value'";
                                                        print_r($sql);
                                                        $result = $db->query($sql);
                                                        $row = $result->fetch_assoc();
                                                        @$additional_price += $row['portion_price'];
                                                    }
                                                }
                                                ?>
                                            <td><?= @$additional_price ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align:right">
                                <a href="package.php?reservation_no='<?= @$reservation_no ?>'" class="btn btn-success" style="width:150px;"><i class="bi bi-arrow-left"></i> Back</a>
                                <button type="submit" name="action" value="add_on"  class="btn btn-success" style="width:150px;">Next <i class="bi bi-arrow-right"></i></button>
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