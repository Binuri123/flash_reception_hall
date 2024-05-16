<?php
include '../header.php';
include '../menu.php';
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>hall/hall.php">Hall</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>hall/hall.php"><i class="bi bi-calendar"></i> Search Hall</a>
            </div>
        </div>
    </div>
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $hall_id = $_GET['hall_id'];

        if (!empty($hall_id)) {
            $db = dbConn();
            $sql = "SELECT * FROM hall WHERE hall_id='$hall_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                //var_dump($row);
                ?>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="card bg-light col-md-6">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered border-secondary">
                                    <thead class="bg-secondary-light border-dark text-center">
                                        <tr>
                                            <th colspan="2">Hall Details</th>
                                        </tr>
                                        <tr>
                                            <th scope="col">Field</th>
                                            <th scope="col">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Hall No</td>
                                            <td><?= $row['hall_no'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td><?= $row['hall_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Availability</td>
                                            <td><?= $row['availability'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Minimum Capacity</td>
                                            <td><?= $row['min_capacity'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Maximum Capacity</td>
                                            <td><?= $row['max_capacity'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Hall Image</td>
                                            <td><img class="img-fluid" src="../assets/images/hall/<?= empty($row['hall_image']) ? "noimage.jpg" : $row['hall_image'] ?>" style="width:100px;height:100px;"></td>
                                        </tr>
                                        <tr>
                                            <td>Facilities</td>
                                            <td>
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
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Allowed Events</td>
                                            <td>
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
                                    </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class=" col-md-3"></div>
                </div>
                <?php
            }
        }
    }
    ?>
</main>
<?php include '../footer.php'; ?>