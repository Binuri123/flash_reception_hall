<?php include '../../header.php'; ?>
<?php include '../../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $menu_package_id = $_GET['menu_package_id'];
        $menu_updated = $_GET['menu_updated'];
        $updated_menu_fields = explode(',', $menu_updated);
        //var_dump($menu_updated);
        if (!empty($menu_package_id)) {
            $db = dbConn();
            $sql = "SELECT * FROM menu_package m INNER JOIN menu_type mt ON mt.menu_type_id=m.menu_type_id WHERE menu_package_id='$menu_package_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                //var_dump($row);
                ?>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu.php">Menu</a></li>
                            <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu_package.php">Menu Package</a></li>
                            <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/fixed_menu/fixed_menu.php">Fixed Menu</a></li>
                            <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/fixed_menu/edit.php?menu_package_id=<?= $menu_package_id ?>">Update</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Success</li>
                        </ol>
                    </nav>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/fixed_menu/add.php"><i class="bi bi-plus-circle"></i> New Menu</a>
                            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/fixed_menu/fixed_menu.php"><i class="bi bi-calendar"></i> Search Menu</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-2"></div>
                    <div class="alert alert-warning col-md-8" role="alert">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center">
                                <h4><strong>Successfully Updated...!!!</strong></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Updated Menu Package Details</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="alert-heading"></h4>
                                <h5 class="text-center"></h5>
                                <p style="font-weight:bold;" class="<?= in_array('menu_package_name', $updated_menu_fields) ? 'text-warnning' : 'text-secondary' ?>">Menu Package Name: <?= $row['menu_package_name'] ?></p>
                                <p style="font-weight:bold;" class="<?= in_array('menu_type_id', $updated_menu_fields) ? 'text-warnning' : 'text-secondary' ?>">Menu Type: <?= $row['menu_type_name'] ?></p>
                                <p style="font-weight:bold;" class="<?= in_array('total_price', $updated_menu_fields) ? 'text-warnning' : 'text-secondary' ?>">Total Price: <?= $row['total_price'] ?></p>
                                <p style="font-weight:bold;" class="<?= in_array('profit_ratio', $updated_menu_fields) ? 'text-warnning' : 'text-secondary' ?>">Profit Ratio: <?= $row['profit_ratio'] ?></p>
                                <p style="font-weight:bold;" class="<?= in_array('final_price', $updated_menu_fields) ? 'text-warnning' : 'text-secondary' ?>">Final Price: <?= $row['final_price'] ?></p>
                                <p style="font-weight:bold;" class="<?= in_array('availability', $updated_menu_fields) ? 'text-warnning' : 'text-secondary' ?>">Availability: <?= $row['availability'] ?></p>
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm bg-light table-bordered border-secondary">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Item</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $db = dbConn();
                                            $sql = "SELECT mc.category_name,mc.category_id,mi.item_name "
                                                    . "FROM menu_package m INNER JOIN menu_package_item mpi ON mpi.menu_package_id=m.menu_package_id "
                                                    . "INNER JOIN item_category mc ON mc.category_id=mpi.category_id "
                                                    . "INNER JOIN menu_item mi ON mi.item_id=mpi.item_id "
                                                    . "WHERE m.menu_package_id='$menu_package_id' ORDER BY mc.category_id ASC";
                                            $result_item = $db->query($sql);
                                            if ($result_item->num_rows > 0) {
                                                $i = 1;
                                                while ($row = $result_item->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $row['category_name'] ?></td>
                                                        <td><?= $row['item_name'] ?></td>
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
                        <div class="mb-3 col-md-2"></div>
                    </div>
                </div>
                <?php
            }
        }
    }
    ?>
</main>
<?php include '../../footer.php'; ?>