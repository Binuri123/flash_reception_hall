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
                    <li class="breadcrumb-item"><a href="<?= SYSTEM_PATH ?>service/add.php">Add</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Success</li>
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
        $item_id = $_GET['service_id'];

        if (!empty($item_id)) {
            $db = dbConn();
            $sql = "SELECT sc.category_id,sc.category_name,s.service_name,s.service_price,s.addon_status,s.profit_ratio,s.final_price,s.availability FROM service s INNER JOIN service_category sc ON sc.category_id=s.category_id WHERE service_id='$service_id'";
            //print_r($sql);
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                //var_dump($row);
                ?>
                <div class="row">
                    <div class="mb-3 col-md-3"></div>
                    <div class="alert alert-success col-md-6" role="alert">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center">
                                <h4><strong>Successfully Added...!!!</strong></h4><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Service Details</h5>
                                <p style="font-weight:bold;margin:0;">Service Category: <?= $row['category_name'] ?></p>
                                <p style="font-weight:bold;margin:0;">Service Name: <?= $row['service_name'] ?></p>
                                <p style="font-weight:bold;margin:0;">Approved to be an Additional: <?= $row['addon_status'] ?></p>
                                <p style="font-weight:bold;margin:0;">Service Price(Rs.): <?= $row['service_price'] ?></p>
                                <p style="font-weight:bold;margin:0;">Profit Ratio(%): <?= $row['profit_ratio'] ?></p>
                                <p style="font-weight:bold;margin:0;">Final Price(Rs.): <?= $row['final_price'] ?></p>
                                <p style="font-weight:bold;margin:0;">Availability: <?= $row['availability'] ?></p>
                                <p style="font-weight:bold;margin:0;">Events Allowed the Service: </p>
                                <ul>
                                    <?php
                                    $sql_events = "SELECT e.event_name FROM event e INNER JOIN event_service es ON e.event_id=es.event_id WHERE service_id='$service_id'";
                                    $result_events = $db->query($sql_events);
                                    while($row_events=$result_events->fetch_assoc()){
                                        ?>
                                    <li><?=$row_events['event_name']?></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-3"></div>
                </div>
                <?php
            }
        }
    }
    ?>
</main>
<?php include '../footer.php'; ?>