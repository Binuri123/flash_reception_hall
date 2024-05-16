<?php include '../../header.php'; ?>
<?php include '../../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $category_id = $_GET['category_id'];
        $category_id = intval($category_id);
        //var_dump($category_id);
        $updated = $_GET['values'];
        $updated_fields = explode(',', $updated);

        //var_dump($updated_fields);

        if (!empty($category_id)) {
            $db = dbConn();
            $sql = "SELECT * FROM item_category WHERE category_id='$category_id'";
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
                                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/item_category/item_category.php">Item Category</a></li>
                                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/item_category/edit.php?category_id=<?= $category_id ?>">Update</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Success</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/item_category/add.php"><i class="bi bi-plus-circle"></i> New Category</a>
                            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>menu_package/item_category/item_category.php"><i class="bi bi-calendar"></i> Search Category</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="alert alert-warning col-md-6" role="alert">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center">
                                <h4><strong>Successfully Updated...!!!</strong></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8" style="text-align:left">
                                <h5>Updated Details</h5>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('category_name', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Category Name: <?= $row['category_name'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('availability', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Availability: <?= $row['availability'] ?></p>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-3"></div>
                </div>
            </div>
            <?php
        }
    }
}
?>


</main>

<?php include '../../footer.php'; ?>