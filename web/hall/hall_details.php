<?php
include '../header.php';
?>
<main id="main">
    <section>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            extract($_GET);
            //var_dump($_GET);
            $get_array = explode('.', $hall_id);
            $hall_id = $get_array[0];
            $hall_image = $get_array[1];
            $db = dbConn();
            $sql = "SELECT * FROM hall WHERE hall_id='$hall_id'";
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
                                <h6><strong><?= $row['hall_no'] . ' - ' . $row['hall_name'] ?></strong></h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="font-size:13px;">
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 text-center">
                                <img src="<?= WEB_PATH ?>assets/img/halls/<?= $hall_image ?>.jpg" style="height:300px;width:300px;" class="mb-3">   
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p style="margin:0;">Minimum Capacity</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p style="margin:0;"><?= $row['min_capacity'] ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p style="margin:0;">Maximum Capacity</p>
                                    </div>
                                    <div class="col-md-8">
                                        <p style="margin:0;"><?= $row['max_capacity'] ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p style="margin:0;">Facilities</p>
                                    </div>
                                    <div class="col-md-8">
                                        <ul>
                                            <?php
                                            $facility_list = explode(',', $row['facilities']);
                                            foreach ($facility_list as $facility) {
                                                ?>
                                                <li style="margin:0;"><?= $facility ?></li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
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