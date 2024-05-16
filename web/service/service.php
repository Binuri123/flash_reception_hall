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
                    $sql = "SELECT c.category_id,c.category_name,c.description FROM service_category c WHERE availability ='Available'";
                    $result = $db->query($sql);
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-md-3 mb-3">
                            <div class="card bg-light">
                                <div class="card-header text-secondary mt-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="<?= WEB_PATH ?>service/service_category.php?category_id=<?= $row['category_id'] ?>" style="color:grey;">
                                                <h6><strong><?= $row['category_name'] ?></strong></h6>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= WEB_PATH ?>service/service_category.php?category_id=<?= $row['category_id'] ?>">
                                    <div class="card-body">
                                        <p style="color:black;font-size:13px;text-align:justify"><strong><i><?= $row['description'] ?></i></strong></p>
                                    </div>
                                </a>
                                <div class="card-footer bg-white" style="text-align:right">
                                    <a class="btn btn-warning btn-sm" href="<?= WEB_PATH ?>service/service_category.php?category_id=<?= $row['category_id'] ?>" style="color:green;">View <i class="bi bi-arrow-right"></i></a>
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