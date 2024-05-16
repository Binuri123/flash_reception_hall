<?php include '../../header.php'; ?>
<?php include '../../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu.php">Menu</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu_package.php">Menu Package</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fixed Menu</li>
            </ol>
        </nav>
        <?php
        if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
            ?>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/fixed_menu/add.php"><i class="bi bi-plus-circle"></i> New Menu</a>
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
        $menu_package_name = cleanInput($menu_package_name);
        $min_price = cleanInput($min_price);
        $max_price = cleanInput($max_price);

        if (!empty($menu_package_name)) {
            //Wild card serach perform using like and %% signs
            $where .= " menu_package_name LIKE '%$menu_package_name%' AND";
        }

        if (!empty($min_price) && empty($price) || !empty($max_price) && empty($price) || !empty($min_price) && !empty($max_price_price) && empty($price)) {
            $message['error_price'] = "To Filter Through the Price You should Select the Price Category";
        } else {
            if (!empty($price) && $price == 'total_price') {
                if (!empty($min_price) && !empty($max_price)) {
                    $where.=" total_price BETWEEN '$min_price' AND '$max_price' AND";
                } elseif (!empty($min_price) && empty($max_price)) {
                    $where.=" total_price BETWEEN '$min_price' AND (SELECT MAX(total_price) FROM menu_package) AND";
                } elseif (empty($min_price) && !empty($max_price)) {
                    $where.=" total_price BETWEEN (SELECT MIN(total_price) FROM menu_package) AND '$max_price' AND";
                } elseif (empty($min_price) && empty($max_price)) {
                    $message['error_price'] = "To filter by the price Enter a Range";
                }
            }
            if (!empty($price) && $price == 'final_price') {
                if (!empty($min_price) && !empty($max_price)) {
                    $where.=" final_price BETWEEN '$min_price' AND '$max_price' AND";
                } elseif (!empty($min_price) && empty($max_price)) {
                    $where.=" final_price BETWEEN '$min_price' AND (SELECT MAX(final_price) FROM menu_package) AND";
                } elseif (empty($min_price) && !empty($max_price)) {
                    $where.=" final_price BETWEEN (SELECT MIN(final_price) FROM menu_package) AND '$max_price' AND";
                } elseif (empty($min_price) && empty($max_price)) {
                    $message['error_price'] = "To filter by the price Enter a Range";
                }
            }
        }
        if (!empty($availability)) {
            //Exact Search perform using = sign
            $where .= " availability ='$availability' AND";
        }

        if (!empty($where)) {
            $where = substr($where, 0, -3);
            $where = " AND $where";
        }
    }
    ?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <h3>Fixed Menu</h3>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                <div class="row">
                    <div class="mb-3 col-md-3" style="font-size:13px">
                        <input type="text" class="form-control" placeholder="Name" name="menu_package_name" value="<?= @$menu_package_name ?>" style="font-size:13px">
                    </div>
                    <div class="mb-3 col-md-3">
                        <select name="availability" class="form-control form-select" style="font-size:13px">
                            <option value="">-Status-</option>
                            <option value="Available" <?php if (@$availability == 'Available') { ?> selected <?php } ?>>Available</option>
                            <option value="Unavailable" <?php if (@$availability == 'Unavailable') { ?> selected <?php } ?>>Unavailable</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <select name="price" class="form-control form-select" style="font-size:13px">
                            <option value="" style="text-align:center">-Price-</option>
                            <option value="total_price" <?php if (@$price == 'total_price') { ?> selected <?php } ?>>Total Price</option>
                            <option value="final_price" <?php if (@$price == 'final_price') { ?> selected <?php } ?>>Final Price</option>
                        </select>
                        <div class="text-danger"><?= @$message["error_price"] ?></div>
                    </div>
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Min" name="min_price" value="<?= @$min_price ?>" style="font-size:13px">
                    </div>
                    <div class="mb-3 col-md-2">
                        <input type="text" class="form-control" placeholder="Max" name="max_price" value="<?= @$max_price ?>" style="font-size:13px">
                    </div>

                    <div class="mb-3 col-md-4">
                        <button type="submit" class="btn btn-warning btn-sm" style="width:100px;font-size:13px"><i class="bi bi-search"></i> Search</button>
                        <a href="<?= SYSTEM_PATH ?>menu_package/fixed_menu/fixed_menu.php" class="btn btn-info btn-sm" style="width:100px;font-size:13px;"><i class="bi bi-eraser"></i> Clear</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="table-responsive">
                <?php
                $sql = "SELECT menu_package_id,menu_package_name,total_price,final_price,availability FROM menu_package WHERE menu_type_id = 1 $where";
                //print_r($sql);
                $db = dbConn();
                $result = $db->query($sql);
                ?>
                <table class="table table-striped table-sm">
                    <thead class="bg-secondary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '4') {
                                ?>
                                <th scope="col">Total Price</th>
                                <?php
                            }
                            ?>
                            <th scope="col">Final Price</th>
                            <th scope="col">Availability</th>
                            <?php
                            if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
                                ?>
                                <th scope="col"></th>
                                <?php
                            }
                            ?>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $row['menu_package_name'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2' || $_SESSION['user_role_id'] == '4') {
                                        ?>
                                        <td><?= $row['total_price'] ?></td>
                                        <?php
                                    }
                                    ?>
                                    <td><?= $row['final_price'] ?></td>
                                    <td><?= $row['availability'] ?></td>
                                    <?php
                                    if ($_SESSION['user_role_id'] == '1' || $_SESSION['user_role_id'] == '2') {
                                        ?>
                                        <td><a href="edit.php?menu_package_id=<?= $row['menu_package_id'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a></td>
                                        <?php
                                    }
                                    ?>
                                    <td><a href="view.php?menu_package_id=<?= $row['menu_package_id'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a></td>
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
        <div class="col-md-2"></div>
    </div>
</main>

<?php include '../../footer.php'; ?>
