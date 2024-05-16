<?php
include '../header.php';
?>
<main id="main">
    <section>
        <div class="row mt-5">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="row">
                    <?php
                    $db = dbConn();
                    $sql = "SELECT menu_package_id,menu_package_name FROM menu_package";
                    $result = $db->query($sql);
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header bg-white text-secondary mt-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="<?= WEB_PATH ?>menu_package/menu_package_details.php?menu_package_id=<?= $row['menu_package_id'] ?>">
                                                <h6><strong><?= $row['menu_package_name'] ?> Package</strong></h6>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= WEB_PATH ?>menu_package/menu_package_details.php?menu_package_id=<?= $row['menu_package_id'] ?>">
                                    <div class="card-body" style="height:300px;background-image:url('../assets/img/menu_packages/<?= $i ?>.jpg');background-size:cover;"></div>
                                </a>
                                <div class="card-footer bg-white" style="text-align:right">
                                    <a class="btn btn-warning btn-sm" href="<?= WEB_PATH ?>menu_package/menu_package_details.php?menu_package_id=<?= $row['menu_package_id'] ?>" style="color:green;">View <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
</main>
<?php
include '../footer.php';
?>