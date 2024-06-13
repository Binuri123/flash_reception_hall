<?php
ob_start();
include '../customer/header.php';
include '../customer/sidebar.php';
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Reservation</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= WEB_PATH ?>customer/dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Reservation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_SESSION['additional_items'])) {
        $item = array();
        $portion_qty = array();
        $total_portion_price = array();
        foreach ($_SESSION['additional_items'] as $unit) {
            $item_id = $unit['item_id'];
            $item[] = $item_id;
            $portion_qty[$item_id] = $unit['portion_qty'];
            $total_portion_price = $unit['total_portion_price'];
        }
        if (!empty($_SESSION['reservation_details']['additional_price'])) {
            @$additional_price = $_SESSION['reservation_details']['additional_price'];
        }
    }

    extract($_POST);
//    echo 'item';
//    var_dump($item);
//    echo 'qty';
//    var_dump($portion_qty);
    if (isset($item)) {
        @$additional_price = 0;
        foreach ($item as $unit) {
            $db = dbConn();
            $sql = "SELECT i.item_id,ai.addon_price FROM menu_item i LEFT JOIN additional_allowed_item ai ON ai.item_id=i.item_id WHERE i.item_id='$unit'";
            //print_r($sql);
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            //var_dump($row);
            if (in_array($unit, $item)) {
                $qty = $portion_qty[$unit];
                $price = $row['addon_price'];
                $total_portion_price = $row['addon_price'] * intval($qty);
                $additional_price += $total_portion_price;
                //var_dump($total_portion_price);
            }
            $_SESSION['additional_items'][$row['item_id']] = array('item_id' => $row['item_id'], 'portion_qty' => $qty, 'portion_price' => $row['addon_price'], 'total_portion_price' => $total_portion_price);

            //var_dump($_SESSION['additional_items']);
        }
        //var_dump($additional_price);
        $_SESSION['reservation_details']['additional_price'] = $additional_price;
    }

    if (!empty($item) && !empty($_SESSION['additional_items'])) {
        foreach ($_SESSION['additional_items'] as $value) {
            $item_id = $value['item_id'];
            if (!in_array($item_id, $item)) {
                @$total_portion_price = 0;
                @$portion_qty[$item_id] = 0;
                //@$additional_price = number_format(@$additional_price, 2);
                unset($_SESSION['additional_items'][$item_id]);
                //print_r($_SESSION['additional_items']);
            }
        }
    } elseif (empty($item)) {
        unset($_SESSION['additional_items']);
    }

    //var_dump($_POST);
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'add_on') {
        $message = array();
        $guest_count = $_SESSION['reservation_details']['event_details']['guest_count'];
        if (!empty($item)) {
            foreach ($item as $value) {
                $item_id = $value;
                if (empty($portion_qty[$item_id])) {
                    $message['error_portion_qty' . $item_id] = "Portion Qty should not be null..!";
                } else {
                    if ($portion_qty[$item_id] < 0) {
                        $message['error_portion_qty' . $item_id] = "Portion Qty should not be negative..!";
                    } elseif ($portion_qty[$item_id] > $guest_count) {
                        $message['error_portion_qty' . $item_id] = "Maximum Portion Qty is $guest_count..!";
                    }
                }
            }
        }
        //var_dump($message);
        if (empty($message)) {
            header('Location:services.php');
        }
    }
    ?>
    <section class="section dashboard">
        <?php
        //var_dump(@$_SESSION['reservation_details']['additional_items']);
        //var_dump(@$_SESSION['reservation_details']['additional_price']);
        //echo @$additional_price;
        ?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card bg-light">
                    <div class="card-header bg-light">
                        <ul class="nav nav-tabs card-header-tabs nav-justified" style="font-size:14px;">
                            <li class="nav-item"><a class="nav-link" href="?tab=event_details">Event Details</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=package">Package</a></li>
                            <li class="nav-item"><a class="nav-link active" href="?tab=add_ons">Add-ons</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=service">Service</a></li>
                            <li class="nav-item"><a class="nav-link" href="?tab=invoice">Invoice</a></li>
                        </ul>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mt-3 mb-3">
                                    <div class="card-body" style="font-size:14px;">
                                        <div class="tab-container active">
                                            <form  method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                                <div class="row">
                                                    <div class="col-md-6 mt-3">
                                                        <a href="<?= WEB_PATH ?>reservation/package.php" class="btn btn-success btn-sm" style="width:100px;font-size:13px;"><i class="bi bi-arrow-left"></i> Back</a>
                                                    </div>
                                                    <div class="col-md-6 mt-3" style="text-align:right">
                                                        <button type="submit" name="action" value="add_on" class="btn btn-success btn-sm" style="width:100px;font-size:13px;">Next <i class="bi bi-arrow-right"></i></button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mt-3">
                                                        <p style="margin:0;color:lightseagreen;"><strong><i>You can request other items from the following list addition to the previous menu included in the selected package.</i></strong></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label class="form-label" for="total_additional_price"><strong><i>Total Addon Price (Rs.)</i></strong></label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <?php
                                                                if (!empty($_SESSION['additional_items'])) {
                                                                    $additional_price = $_SESSION['reservation_details']['additional_price'];
                                                                } else {
                                                                    $additional_price = 0;
                                                                }
                                                                $additional_price = number_format($additional_price, '2', '.', ',');
                                                                ?>
                                                                <div><?= @$additional_price ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead style="font-size:13px;text-align: center">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Category</th>
                                                                        <th scope="col">Item Name</th>
                                                                        <th scope="col">Price Per Portion (Rs.)</th>
                                                                        <th scope="col"></th>
                                                                        <th scope="col">Quantity</th>
                                                                        <th scope="col">Total (Rs.)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody style="font-size:13px;">
                                                                    <?php
                                                                    $db = dbConn();
                                                                    $selected_package = $_SESSION['reservation_details']['package_details']['package_id'];
                                                                    $sql = "SELECT c.category_id,c.category_name,i.item_id,i.item_name,ai.addon_price FROM menu_item i "
                                                                            . "LEFT JOIN additional_allowed_item ai ON ai.item_id=i.item_id "
                                                                            . "LEFT JOIN item_category c ON c.category_id=i.category_id "
                                                                            . "WHERE i.addon_status = 'Yes' AND i.availability = 'Available' AND ai.item_id NOT IN"
                                                                            . "(SELECT item_id FROM menu_package_item WHERE menu_package_id="
                                                                            . "(SELECT menu_package_id FROM package WHERE package_id=$selected_package)) ORDER BY category_id ASC";
                                                                    //print_r($sql);
                                                                    $result = $db->query($sql);
                                                                    $i = 1;
                                                                    while ($row = $result->fetch_assoc()) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?= $i ?></td>
                                                                            <td><?= $row['category_name'] ?></td>
                                                                            <td><?= $row['item_name'] ?></td>
                                                                            <td><?= $row['addon_price'] ?></td>
                                                                            <td style="width:50px">
                                                                                <input class="form-check-input" onchange="form.submit()" type="checkbox" id="<?= $row['item_id'] ?>" name="item[]" value="<?= $row['item_id'] ?>" <?php if (isset($item) && in_array($row['item_id'], $item)) { ?>checked <?php } ?>>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                if (!empty($item)) {
                                                                                    $item_id = $row['item_id'];
                                                                                }
                                                                                $max = $_SESSION['reservation_details']['event_details']['guest_count'];
                                                                                ?>
                                                                                <input type="number" class="form-control" name="portion_qty[<?= $row['item_id'] ?>]" onchange="form.submit()" value="<?= @$portion_qty[$item_id] ?>" style="font-size:13px;">
                                                                                <div class="text-danger"><?= @$message['error_portion_qty' . $item_id] ?></div>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                if (!empty($_SESSION['additional_items'][$row['item_id']])) {
                                                                                    $total_portion_price = $_SESSION['additional_items'][$row['item_id']]['total_portion_price'];
                                                                                } else {
                                                                                    $total_portion_price = 0;
                                                                                }
                                                                                $total_portion_price = number_format($total_portion_price, '2', '.', ',');
                                                                                ?>
                                                                                <div style="vertical-align:middle;"><?= @$total_portion_price ?></div>
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
                                                                        <td style="text-align:right" colspan="4"><strong>Total (Rs.)</strong></td>
                                                                        <td><?= @$additional_price ?></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
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
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php include('../customer/footer.php') ?>
<?php ob_end_flush() ?>