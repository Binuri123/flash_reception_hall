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
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_SESSION['reservation_details']['additional_items'])) {
        $item = array();
        $portion_qty = array();
        $total_portion_price = array();
        foreach ($_SESSION['reservation_details']['additional_items'] as $unit) {
            $item_id = $unit['item_id'];
            $item[] = $item_id;
            $portion_qty[$item_id] = $unit['portion_qty'];
            $total_portion_price[$item_id] = $unit['total_portion_price'];
        }
        if (!empty($_SESSION['reservation_details']['additional_price'])) {
            @$additional_price = $_SESSION['reservation_details']['additional_price'];
        }
    }

    extract($_POST);
    if (isset($item)) {
        @$additional_price = 0;
        foreach ($item as $unit) {
            $db = dbConn();
            $sql = "SELECT item_id,portion_price FROM menu_item WHERE item_id='$unit'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            //var_dump($row);
            if (in_array($unit, $item)) {
                $qty = $portion_qty[$unit];
                $price = $row['portion_price'];
                $total_portion_price[$unit] = $row['portion_price'] * intval($qty);
                $total_price = $total_portion_price[$unit];
                $additional_price += $total_portion_price[$unit];
            }
            $_SESSION['reservation_details']['additional_items'][$row['item_id']] = array('item_id' => $row['item_id'], 'portion_qty' => $qty, 'portion_price' => $row['portion_price'], 'total_portion_price' => $total_portion_price[$unit]);
        }
    }

    if (!empty($item) && !empty($_SESSION['reservation_details']['additional_items'])) {
        foreach ($_SESSION['reservation_details']['additional_items'] as $value) {
            $item_id = $value['item_id'];
            if (!in_array($item_id, $item)) {
                @$total_portion_price[$item_id] = 0;
                @$portion_qty[$item_id] = 0;
                //@$additional_price = number_format(@$additional_price, 2);
                unset($_SESSION['reservation_details']['additional_items'][$item_id]);
                print_r($_SESSION['reservation_details']);
            }
        }
    } elseif (empty($item)) {
        unset($_SESSION['reservation_details']['additional_items']);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$action == 'add_on') {
//var_dump($_POST);

        if (!empty($item)) {
            $_SESSION['reservation_details']['additional_price'] = $additional_price;
        }
        header('Location:invoice.php');
    }
    ?>
    <section class="section dashboard">
        <?php
        var_dump(@$_SESSION['reservation_details']['additional_items']);
        var_dump(@$_SESSION['reservation_details']['additional_price']);
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
                                                    <div class="col-md-12 mt-3">
                                                        <p style="margin:0;color:lightseagreen;"><strong><i>You can request other items from the following list addition to the previous menu included in the selected package.</i></strong></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead style="text-align: center">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Category</th>
                                                                        <th scope="col">Item Name</th>
                                                                        <th scope="col">Price Per Portion</th>
                                                                        <th scope="col"></th>
                                                                        <th scope="col">Quantity</th>
                                                                        <th scope="col">Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $db = dbConn();
                                                                    $sql = "SELECT c.category_id,c.category_name,i.item_id,i.item_name,ai.addon_price FROM menu_item i LEFT JOIN additional_allowed_item ai ON ai.item_id=i.item_id LEFT JOIN item_category c ON c.category_id=i.category_id WHERE i.addon_status = 'Yes' AND i.availability = 'Available' ORDER BY category_id ASC";
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
                                                                                ?>
                                                                                <input type="number" class="form-control" name="portion_qty[<?= $row['item_id'] ?>]" onchange="form.submit()" value="<?= @$portion_qty[$item_id] ?>" max="<?= $_SESSION['reservation_details']['event_details']['guest_count'] ?>">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control" readonly name="total_portion_price[<?= $row['item_id'] ?>]" value="<?= (isset($_SESSION['reservation_details']['additional_items'][$row['item_id']])) ? $_SESSION['reservation_details']['additional_items'][$row['item_id']]['total_portion_price'] : 0 ?>">
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
                                                                        <td style="text-align:right" colspan="4"><strong>Total</strong></td>
                                                                        <td><?= @$additional_price ?></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
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