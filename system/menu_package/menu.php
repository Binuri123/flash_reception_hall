<?php 
include '../header.php';
include '../menu.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Menu</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>menu_package/menu_package.php" style="text-decoration:none;color:white">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as total_menu_pakages FROM menu_package";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $menu_package_count = $row['total_menu_pakages'];
                            ?>
                            <h4># Menu Packages<br><?= $menu_package_count ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>menu_package/item_category/item_category.php" style="text-decoration:none;color:white">
                    <div class="card bg-secondary text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as total_item_categories FROM item_category";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $item_category_count = $row['total_item_categories'];
                            ?>
                            <h4># Item Categories<br><?= $item_category_count ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>menu_package/menu_item/menu_item.php" style="text-decoration:none;color:white">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as total_items FROM menu_item";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $item_count = $row['total_items'];
                            ?>
                            <h4># Menu Items<br><?= $item_count ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">

            </div>
        </div>
    </div>
</main>
<?php include '../footer.php'; ?>
