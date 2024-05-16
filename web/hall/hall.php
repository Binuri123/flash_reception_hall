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
                    $sql = "SELECT hall_id,hall_no,hall_name FROM hall";
                    $result = $db->query($sql);
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header bg-white text-secondary mt-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="<?= WEB_PATH ?>hall/hall_details.php?hall_id=<?= $row['hall_id'].'.'.$i ?>">
                                                <h6><strong><?= $row['hall_no'] . ' - ' . $row['hall_name'] ?></strong></h6>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= WEB_PATH ?>hall/hall_details.php?hall_id=<?= $row['hall_id'].'.'.$i ?>">
                                    <div class="card-body" style="height:300px;background-image:url('../assets/img/halls/<?= $i ?>.jpg');background-size:cover;"></div>
                                </a>
                                <div class="card-footer bg-white" style="text-align:right">
                                    <a class="btn btn-warning btn-sm" href="<?= WEB_PATH ?>hall/hall_details.php?hall_id=<?= $row['hall_id'].'.'.$i ?>" style="color:green;">View <i class="bi bi-arrow-right"></i></a>
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