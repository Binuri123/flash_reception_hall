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
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/service.php">Service</a></li>
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/services.php">Services</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View</li>
                </ol>
            </nav>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/add.php"><i class="bi bi-plus-circle"></i> New Service</a>
                <a class="btn btn-sm btn-outline-success" href="<?= SYSTEM_PATH ?>service/services.php"><i class="bi bi-calendar"></i> Search Service</a>
            </div>
        </div>
    </div>
    <?php
    //check the request method
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        //extract the array
        extract($_GET);
        //var_dump($_GET);
        $service_id = $_GET['service_id'];

        if (!empty($service_id)) {
            $db = dbConn();
            $sql = "SELECT sc.category_id,sc.category_name,s.service_name,s.service_type,s.service_price,s.profit_ratio,s.final_price,s.availability FROM service s INNER JOIN service_category sc ON sc.category_id=s.category_id WHERE service_id='$service_id'";
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
                                            <th colspan="2">Service Details</th>
                                        </tr>
                                        <tr>
                                            <th scope="col">Field</th>
                                            <th scope="col">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Category</td>
                                            <td><?= $row['category_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Service Name</td>
                                            <td><?= $row['service_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Service Name</td>
                                            <td><?= ($row['service_type']=='inhouse')?'In House Service':'Out Source Service' ?></td>
                                        </tr>
                                        <tr>
                                            <td>Availability</td>
                                            <td><?= $row['availability'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Events Included the Service</td>
                                            <td>
                                                <ul>
                                                    <?php
                                                    $sql_events = "SELECT event_name FROM event WHERE event_id IN (SELECT event_id FROM event_service WHERE service_id='$service_id')";
                                                    $result_events = $db->query($sql_events);
                                                    while ($row_events = $result_events->fetch_assoc()) {
                                                        ?>
                                                        <li><?= $row_events['event_name'] ?></li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Service Price(Rs.)</td>
                                            <td><?= $row['service_price'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Profit Ratio(%)</td>
                                            <td><?= $row['profit_ratio'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Final Price(Rs.)</td>
                                            <td><?= $row['final_price'] ?></td>
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