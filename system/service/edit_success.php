<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $service_id = $_GET['service_id'];
        //var_dump($item_id);
        $updated = $_GET['values'];
        $updated_fields = explode(',', $updated);

        //var_dump($updated_fields);

        if (!empty($service_id)) {
            $db = dbConn();
            $sql = "SELECT s.service_name,s.addon_status,s.service_price,s.profit_ratio,s.final_price,s.availability,s.category_id,sc.category_name FROM service s LEFT JOIN service_category sc ON sc.category_id=s.category_id WHERE service_id='$service_id'";
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
                                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/service.php">Service</a></li>
                                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/services.php">Services</a></li>
                                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/edit.php?service_id=<?= $service_id ?>">Update</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Success</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/services.php"><i class="bi bi-calendar"></i> Search Service</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-2"></div>
                    <div class="alert alert-warning col-md-8" role="alert">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center;">
                                <h4 class="alert-heading">Successfully Updated...!!!</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div>
                                <h5>Updated Details</h5>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('category_id', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Category: <?= $row['category_name'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('service_name', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Service Name: <?= $row['service_name'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('addon_status', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Approved to be an Additional: <?= $row['addon_status'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('service_price', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Service Price(Rs.): <?= $row['service_price'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('profit_ratio', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Profit Ratio(%): <?= $row['profit_ratio'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('final_price', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Final Price(Rs.): <?= $row['final_price'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('availability', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Availability: <?= $row['availability'] ?></p>
                                <p style="font-weight:bold;margin:0;">Events Allowed the Service: </p>
                                <ul>
                                    <?php
                                    $sql_events = "SELECT e.event_name FROM event e INNER JOIN event_service es ON e.event_id=es.event_id WHERE service_id='$service_id'";
                                    $result_events = $db->query($sql_events);
                                    while ($row_events = $result_events->fetch_assoc()) {
                                        ?>
                                        <li><?= $row_events['event_name'] ?></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
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

<?php include '../footer.php'; ?>