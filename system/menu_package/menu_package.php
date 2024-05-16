<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>menu_package/menu.php">Menu</a></li>
                <li class="breadcrumb-item active" aria-current="page">Menu Package</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>menu_package/fixed_menu/fixed_menu.php" style="text-decoration:none;color:white">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as total_fixed_menu FROM menu_package WHERE menu_type_id=1";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $fixed_menu_count = $row['total_fixed_menu'];
                            ?>
                            <h4># Fixed Menus<br><?= $fixed_menu_count ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>menu_package/customized_menu/custom_menu.php" style="text-decoration:none;color:white">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as total_customized_menu FROM menu_package WHERE menu_type_id=2";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $custom_menu_count = $row['total_customized_menu'];
                            ?>
                            <h4># Custom Menus<br><?= $custom_menu_count ?></h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>

<?php include '../footer.php'; ?>
