<?php
include '../header.php';
?>
<main id="main">
    <section>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            extract($_GET);
            //var_dump($_GET);
            $db = dbConn();
            $sql = "SELECT mt.menu_type_name,m.menu_package_name,m.total_price,m.profit_ratio,m.final_price,m.availability "
                    . "FROM menu_package m INNER JOIN menu_type mt ON mt.menu_type_id=m.menu_type_id "
                    . "WHERE m.menu_package_id='$menu_package_id'";
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
        }
        ?>
        <div class="row mt-4">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white text-secondary mt-2">
                        <div class="row">
                            <div class="col-md-12">
                                <h6><strong><?= $row['menu_package_name'] ?> Package</strong></h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="font-size:15px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4 mb-1">
                                        <p style="margin:0;"><strong>Menu Package Type</strong></p>
                                    </div>
                                    <div class="col-md-8 mb-1">
                                        <p style="margin:0;"><?= $row['menu_type_name'] ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-1">
                                        <p style="margin:0;"><strong>Per Person Rate(Rs.)</strong></p>
                                    </div>
                                    <div class="col-md-8 mb-1">
                                        <p style="margin:0;"><?= $row['final_price'] ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-1">
                                        <p style="margin:0;"><strong>Inclusives</strong></p>
                                        <div class="table-responsive mt-2">
                                            <table class="table table-striped table-bordered table-sm border-secondary">
                                                <thead class="bg-secondary-light border-dark text-center">
                                                    <tr>
                                                        <th colspan="2">Inclusives</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Items</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="vertical-align: middle">
                                                    <?php
                                                    $sql_category = "SELECT * FROM item_category";
                                                    $result_category = $db->query($sql_category);
                                                    if ($result_category->num_rows > 0) {
                                                        while ($row_category = $result_category->fetch_assoc()) {
                                                            $sql_item = "SELECT mi.item_id,mi.item_name FROM menu_package_item mpi LEFT JOIN menu_item mi ON mi.item_id=mpi.item_id WHERE mpi.menu_package_id='$menu_package_id' AND mpi.category_id=" . $row_category['category_id'];
                                                            $result_item = $db->query($sql_item);
                                                            if ($result_item->num_rows > 0) {
                                                                ?>
                                                                <tr>
                                                                    <td><?= $row_category['category_name'] ?></td>
                                                                    <td>
                                                                        <ul>
                                                                            <?php
                                                                            while ($row_item = $result_item->fetch_assoc()) {
                                                                                ?>
                                                                                <li><?= $row_item['item_name'] ?></li>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </section>
</main>
<?php
include '../footer.php';
?>