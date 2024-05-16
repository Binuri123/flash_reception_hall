<?php
include '../../header.php';
include '../../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu.php">Menu</a></li>
                <li class="breadcrumb-item active" aria-current="page">Menu Item</li>
            </ol>
        </nav>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
            ?>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/menu_item/add.php"><i class="bi bi-plus-circle"></i> New Menu Item</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    //Customization of the search query
    $message = array();
    $where = NULL;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        extract($_POST);
        //var_dump($_POST);
        $item_name = cleanInput($item_name);
        if (!empty($category)) {
            //Exact Search perform using = sign
            $where .= " i.category_id='$category' AND";
        }
        if (!empty($item_name)) {
            //Wild card serach perform using like and %% signs
            $where .= " item_name LIKE '%$item_name%' AND";
        }
        if (!empty($availability)) {
            //Exact Search perform using = sign
            $where .= " i.availability ='$availability' AND";
        }
        if (!empty($addon_status)) {
            //Exact Search perform using = sign
            $where .= " addon_status ='$addon_status' AND";
        }

        if (!empty($min_price) && empty($price) || !empty($max_price) && empty($price) || !empty($min_price) && !empty($max_price_price) && empty($price)) {
            $message['error_price'] = "To Filter Through the Price You should Select the Price Category";
        } else {
            if (!empty($price) && $price == 'item_price') {
                if (!empty($min_price) && !empty($max_price)) {
                    $where.=" item_price BETWEEN '$min_price' AND '$max_price' AND";
                } elseif (!empty($min_price) && empty($max_price)) {
                    $where.=" item_price BETWEEN '$min_price' AND (SELECT MAX(item_price) FROM menu_package) AND";
                } elseif (empty($min_price) && !empty($max_price)) {
                    $where.=" item_price BETWEEN (SELECT MIN(item_price) FROM menu_package) AND '$max_price' AND";
                } elseif (empty($min_price) && empty($max_price)) {
                    $message['error_price'] = "To filter by the price Enter a Range";
                }
            }
            if (!empty($price) && $price == 'portion_price') {
                if (!empty($min_price) && !empty($max_price)) {
                    $where.=" portion_price BETWEEN '$min_price' AND '$max_price' AND";
                } elseif (!empty($min_price) && empty($max_price)) {
                    $where.=" portion_price BETWEEN '$min_price' AND (SELECT MAX(portion_price) FROM menu_package) AND";
                } elseif (empty($min_price) && !empty($max_price)) {
                    $where.=" portion_price BETWEEN (SELECT MIN(portion_price) FROM menu_package) AND '$max_price' AND";
                } elseif (empty($min_price) && empty($max_price)) {
                    $message['error_price'] = "To filter by the price Enter a Range";
                }
            }
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " WHERE $where";
        }
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <h3>Menu Item List</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <select class="form-control form-select" name="category" style="font-size:13px;">
                            <option value="" style="text-align:center">-Category-</option>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT category_id,category_name FROM item_category";
                            $result = $db->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['category_id'] ?>" <?php if ($row['category_id'] == @$category) { ?> selected <?php } ?>><?= $row['category_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="Name" name="item_name" value="<?= @$item_name ?>" style="font-size:13px">
                    </div>
                    <div class="mb-3 col-md-3">
                        <select name="availability" class="form-control form-select" style="font-size:13px">
                            <option value="" style="text-align:center">-Availability-</option>
                            <option value="Available" <?php if (@$availability == 'Available') { ?> selected <?php } ?>>Available</option>
                            <option value="Unavailable" <?php if (@$availability == 'Unavailable') { ?> selected <?php } ?>>Unavailable</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <select name="addon_status" class="form-control form-select" style="font-size:13px">
                            <option value="" style="text-align:center">-Addon Status-</option>
                            <option value="Yes" <?php if (@$addon_status == 'Yes') { ?> selected <?php } ?>>Yes</option>
                            <option value="No" <?php if (@$addon_status == 'No') { ?> selected <?php } ?>>No</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <select name="price" class="form-control form-select" style="font-size:13px">
                            <option value="" style="text-align:center">-Price-</option>
                            <option value="item_price" <?php if (@$price == 'item_price') { ?> selected <?php } ?>>Item Price</option>
                            <option value="portion_price" <?php if (@$price == 'portion_price') { ?> selected <?php } ?>>Portion Price</option>
                        </select>
                        <div class="text-danger"><?= @$message["error_price"] ?></div>
                    </div>
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="Min" name="min_price" value="<?= @$min_price ?>" style="font-size:13px">
                    </div>
                    <div class="mb-3 col-md-3">
                        <input type="text" class="form-control" placeholder="Max" name="max_price" value="<?= @$max_price ?>" style="font-size:13px">
                    </div>
                    <div class="mb-3 col-md-3">
                        <button type="submit" class="btn btn-warning btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= SYSTEM_PATH ?>menu_package/menu_item/menu_item.php" class="btn btn-info btn-sm" style="font-size:13px;width:100px;"><i class="bi bi-eraser"></i> Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <?php
                $sql = "SELECT i.item_id,i.category_id,category_name,item_name,item_price,portion_price,i.availability,addon_status,item_image FROM menu_item i LEFT JOIN item_category mc ON mc.category_id=i.category_id LEFT JOIN additional_allowed_item a ON a.item_id=i.item_id $where";
                //print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <table class="table table-striped table-sm">
                    <thead class="bg-secondary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category</th>
                            <th scope="col">Name</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
                                ?>
                                <th scope="col">Price</th>
                                <?php
                            }
                            ?>
                            <th scope="col">Portion Price</th>
                            <th scope="col">Availability</th>
                            <th scope="col">Addon Status</th>
                            <th scope="col">Image</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
                                ?>
                                <th></th>
                                <?php
                            }
                            ?>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            //Load the data accordingly to the query
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['category_name'] ?></td>
                                    <td><?= $row['item_name'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
                                        ?>
                                        <td><?= $row['item_price'] ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td><?= $row['portion_price'] ?></td>
                                    <td><?= $row['availability'] ?></td>
                                    <td><?= $row['addon_status'] ?></td>
                                    <td><img class="img-fluid" style="width:50px;height:50px;" src="<?= SYSTEM_PATH ?>assets/images/menu_item_images/<?= $row['item_image'] ?>"></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
                                        ?>
                                        <td><a href="edit.php?item_id=<?= $row['item_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a></td>
                                        <?php
                                    }
                                    ?>
                                    <td><a href="view.php?item_id=<?= $row['item_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include '../../footer.php'; ?>
