<?php
include '../header.php';
include '../menu.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $hall_id = $_GET['hall_id'];
        //var_dump($hall_id);
        $updated = $_GET['updated_hall_values'];
        $updated_fields = explode(',', $updated);
//        $updated_hall_events = $_GET['updated_hall_events'];
//        $updated_hall_events_list = explode(',', $updated_hall_events);

        //var_dump($updated_fields);

        if (!empty($hall_id)) {
            $db = dbConn();
            $sql = "SELECT * FROM hall WHERE hall_id='$hall_id'";
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
                                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>hall/hall.php">Halls</a></li>
                                <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>hall/edit.php?hall_id=<?= $hall_id ?>">Update</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Success</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>hall/hall.php"><i class="bi bi-calendar"></i> Search Hall</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-2"></div>
                    <div class="alert alert-warning col-md-8" role="alert">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="text-align:center;">Successfully Updated...!!!</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Updated Details</h5>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('hall_name', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Hall Name: <?= $row['hall_name'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('min_capacity', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Minimum Capacity: <?= $row['min_capacity'] ?></p>
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('max_capacity', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Maximum Capacity: <?= $row['max_capacity'] ?></p>
                                <p style="font-weight:bold;" class="<?= in_array('hall_image', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Image: <?= $row['hall_image'] ?></p>
                                <img width="200" src="<?= SYSTEM_PATH ?>assets/images/hall/<?= empty($row['hall_image']) ? "noimage.jpg" : $row['hall_image'] ?>">
                                <p style="font-weight:bold;" class="<?= in_array('availability', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Availability: <?= $row['availability'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p style="font-weight:bold;margin:0;" class="<?= in_array('facilities', $updated_fields) ? 'text-warnning' : 'text-secondary' ?>">Facilities:</p>
                                <?php
                                if ($row['facilities']) {
                                    echo "<ul>";
                                    $facility_list = explode(",", $row['facilities']);
                                    foreach ($facility_list as $value) {
                                        echo "<li class='text-secondary'>" . $value . "</li>";
                                    }
                                    echo "</ul>";
                                }
                                ?>
                            </div>
                            <div class="col-md-6">
                                <p style="font-weight:bold; margin:0;" class="text-secondary">Events:</p>
                                <?php
                                $db = dbConn();
                                $sql_events = "SELECT * FROM hall_event he INNER JOIN event e ON e.event_id=he.event_id WHERE hall_id='$hall_id'";
                                //print_r($sql_events);
                                $result_events = $db->query($sql_events);
                                if ($result_events->num_rows > 0) {
                                    echo "<ul>";
                                    while ($row_events = $result_events->fetch_assoc()) {
                                        //var_dump($row_events);
                                        ?>
                                        <li class="text-secondary"><?= $row_events['event_name'] ?></li>
                                        <?php
                                    }
                                    echo "</ul>";
                                }
                                ?>
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