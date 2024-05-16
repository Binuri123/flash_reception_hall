<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Service</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>service/service_category/service_category.php" style="text-decoration:none;color:white">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as total_service_category FROM service_category";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $service_category_count = $row['total_service_category'];
                            ?>
                            <h3># Categories<br><?= $service_category_count ?></h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>service/services.php" style="text-decoration:none;color:white">
                    <div class="card bg-secondary text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as total_services FROM service";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $services_count = $row['total_services'];
                            ?>
                            <h3># Services<br><?= $services_count ?></h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>service/sub_service/sub_service.php" style="text-decoration:none;color:white">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as total_sub_services FROM sub_service";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $total_sub_services_count = $row['total_sub_services'];
                            ?>
                            <h3># Sub Services<br><?= $total_sub_services_count ?></h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="<?= SYSTEM_PATH ?>service/service_sample/service_sample.php" style="text-decoration:none;color:white">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT count(*) as total_service_packages FROM service_samples";
                            $result = $db->query($sql);
                            $row = $result->fetch_assoc();
                            $total_service_packages_count = $row['total_service_packages'];
                            ?>
                            <h3># Samples<br><?= $total_service_packages_count ?></h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>

<?php include '../footer.php'; ?>
