<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $package_id = $_GET['package_id'];
        $package_updated = $_GET['values'];
        $updated_package_fields = explode(',', $package_updated);

        //var_dump($updated_package_fields);

        if (!empty($package_id)) {
            $db = dbConn();
            $sql = "SELECT p.package_name,e.event_name,m.menu_package_name,p.total_price,p.service_charge,p.final_price,p.display_price,p.per_person_price,p.availability FROM package p INNER JOIN event e ON p.event_id=e.event_id INNER JOIN menu_package m ON p.menu_package_id=m.menu_package_id WHERE p.package_id='$package_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                //var_dump($row);
                ?>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>package/package.php">Package</a></li>
                            <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>package/edit.php?package_id=<?= $package_id ?>">Update</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Success</li>
                        </ol>
                    </nav>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>package/package.php"><i class="bi bi-calendar"></i> Search Package</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-2"></div>
                    <div class="alert alert-warning col-md-8" role="alert">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center;">
                                <h4>Successfully Updated...!!!</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-center">Updated Details</h5>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('package_name', $updated_package_fields) ? 'text-warnning' : 'text-secondary' ?>">Package Name: <?= $row['package_name'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('event_id', $updated_package_fields) ? 'text-warnning' : 'text-secondary' ?>">Event Type: <?= $row['event_name'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('menu_package_id', $updated_package_fields) ? 'text-warnning' : 'text-secondary' ?>">Menu: <?= $row['menu_package_name'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('total_price', $updated_package_fields) ? 'text-warnning' : 'text-secondary' ?>">Total Price(Rs.): <?= number_format($row['total_price'],'2','.',',') ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('service_charge', $updated_package_fields) ? 'text-warnning' : 'text-secondary' ?>">Service Charge(%): <?= number_format($row['service_charge'],'2') ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('final_price', $updated_package_fields) ? 'text-warnning' : 'text-secondary' ?>">Final Price(Rs.): <?= number_format($row['final_price'],'2','.',',') ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('display_price', $updated_package_fields) ? 'text-warnning' : 'text-secondary' ?>">Display Price(Rs.): <?= number_format($row['display_price'],'2','.',',') ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('per_person_price', $updated_package_fields) ? 'text-warnning' : 'text-secondary' ?>">Per Person Price(Rs.): <?= number_format($row['per_person_price'],'2','.',',') ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('availability', $updated_package_fields) ? 'text-warnning' : 'text-secondary' ?>">Availability: <?= $row['availability'] ?></p>
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