<?php 
include '../../header.php';
include '../../menu.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $item_id = $_GET['item_id'];
        //var_dump($item_id);
        $updated = $_GET['values'];
        $updated_fields = explode(',', $updated);

        //var_dump($updated_fields);

        if (!empty($item_id)) {
            $db = dbConn();
            $sql = "SELECT mc.category_name,i.item_name,i.availability,i.item_price,i.profit_ratio,i.portion_price,i.item_image,i.addon_status,a.additional_ratio,a.addon_price FROM menu_item i LEFT JOIN item_category mc ON mc.category_id=i.category_id LEFT JOIN additional_allowed_item a ON a.item_id=i.item_id WHERE i.item_id='$item_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                //var_dump($row);
                ?>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu.php">Menu</a></li>
                                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu_package.php">Menu Package</a></li>
                                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu_item/menu_item.php">Menu Item</a></li>
                                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu_item/edit.php?item_id=<?= $item_id ?>">Update</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Success</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/menu_item/add.php"><i class="bi bi-plus-circle"></i> New Item</a>
                            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/menu_item/menu_item.php"><i class="bi bi-calendar"></i> Search Item</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-3"></div>
                    <div class="alert alert-warning col-md-6" role="alert">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="text-align:center">Successfully Updated...!!!</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align:left">
                                <h5>Updated Details</h5>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('category_id', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Category: <?= $row['category_name'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('item_name', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Item Name: <?= $row['item_name'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('availability', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Availability: <?= $row['availability'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('item_price', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Price: <?= $row['item_price'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('profit_ratio', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Profit Ratio: <?= $row['profit_ratio'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('portion_price', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Portion Price: <?= $row['portion_price'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('item_image', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Image: <?= $row['item_image'] ?></p>
                                <img style="width:150px;height:150px;" src="<?= SYSTEM_PATH ?>assets/images/menu_item_images/<?= empty($row['item_image']) ? "noimage.jpg" : $row['item_image'] ?>">
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('addon_status', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Approved as an Addon: <?= $row['addon_status'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('additional_ratio', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Additional Ratio: <?= $row['additional_ratio'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('addon_price', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Addon Price: <?= $row['addon_price'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-3"></div>
                </div>
                <?php
            }
        }
    }
    ?>


</main>

<?php include '../../footer.php'; ?>