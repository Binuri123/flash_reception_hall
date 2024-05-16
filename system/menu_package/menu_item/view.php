<?php
include '../../header.php';
include '../../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu.php">Menu</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu_item/menu_item.php">Menu Item</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View</li>
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
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $item_id = $_GET['item_id'];

        if (!empty($item_id)) {
            $db = dbConn();
            $sql = "SELECT category_name,item_name,i.availability,item_price,profit_ratio,portion_price,item_image,addon_status,additional_ratio,addon_price "
                    . "FROM menu_item i LEFT JOIN item_category mc ON mc.category_id=i.category_id "
                    . "LEFT JOIN additional_allowed_item a ON a.item_id=i.item_id WHERE i.item_id='$item_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                //var_dump($row);
                ?>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="card bg-light col-md-6">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered border-secondary">
                                    <thead class="bg-secondary-light border-dark text-center">
                                        <tr>
                                            <th colspan="2">Item Details</th>
                                        </tr>
                                        <tr>
                                            <th scope="col">Field</th>
                                            <th scope="col">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Category</td>
                                            <td><?= $row['category_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Item Name</td>
                                            <td><?= $row['item_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Availability</td>
                                            <td><?= $row['availability'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Item Price(Rs.)</td>
                                            <td><?= $row['item_price'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Profit Ratio(%)</td>
                                            <td><?= $row['profit_ratio'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Portion Price(Rs.)</td>
                                            <td><?= $row['portion_price'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Item Image</td>
                                            <td><img class="img-fluid" src="../../assets/images/menu_item_images/<?= empty($row['item_image']) ? "noimage.jpg" : $row['item_image'] ?>" style="width:100px;height:100px;"></td>
                                        </tr>
                                        <tr>
                                            <td>Allowed as Additional</td>
                                            <td><?= $row['addon_status'] ?></td>
                                        </tr>
                                        <?php
                                        if ($row['addon_status'] == 'Yes') {
                                            ?>
                                            <tr>
                                                <td>Additional Ratio(%)</td>
                                                <td><?= $row['additional_ratio'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Price as an Addon(Rs.)</td>
                                                <td><?= $row['addon_price'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class=" col-md-3"></div>
                </div>
                <?php
            }
        }
    }
    ?>
</main>
<?php include '../../footer.php'; ?>